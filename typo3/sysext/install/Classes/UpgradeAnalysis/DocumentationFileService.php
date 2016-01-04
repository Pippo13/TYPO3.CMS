<?php
declare(strict_types = 1);
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
namespace TYPO3\CMS\Install\UpgradeAnalysis;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\StringUtility;

/**
 * Provide information about documentation files
 */
class DocumentationFileService
{

    /**
     * the link template for creating links to the rendered documentation
     */
    const LINK_TEMPLATE = 'https://docs.typo3.org/typo3cms/extensions/core/latest/Changelog/%s/%s.html';

    /**
     * @var array unified array of used tags
     */
    protected $tagsTotal = [];

    /**
     * traverse directory given, select files
     *
     * @param string $path
     *
     * @return array file details of affected documentation files
     * @throws \InvalidArgumentException
     */
    public function findDocumentationFiles(string $path) : array
    {
        $documentationFiles = [];
        $versionDirectories = scandir($path);

        $fileInfo = pathinfo($path);
        $absolutePath = $fileInfo['dirname'] . DIRECTORY_SEPARATOR . $fileInfo['basename'];
        foreach ($versionDirectories as $version) {
            $directory = $absolutePath . DIRECTORY_SEPARATOR . $version;
            $documentationFiles += $this->getDocumentationFilesForVersion($directory,
                $version);
        }
        $this->tagsTotal = $this->collectTagTotal($documentationFiles);

        return $documentationFiles;
    }

    /**
     * @param array $fileInfo
     *
     * @return bool
     * @throws \InvalidArgumentException
     */
    protected function isRelevantFile(array $fileInfo) : bool
    {
        return $fileInfo['extension'] === 'rst' && $fileInfo['filename'] !== 'Index';
    }

    /**
     * Add tags represented by the version
     *
     * provided are the main version and the complete version
     * example: version = 8.0
     * tags extracted are 8, 8.0
     *
     * @param string $version
     * @param array $file file content, each line is an array item
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    protected function extractTags(string $version, array $file) : array
    {
        $tags = $this->extractTagsFromFile($file);
        // second line is headline, starting with the category like Breaking, Important or Feature
        $tags[] = $this->extractCategoryFromHeadline($file[1]);
        if (strpos($version, '.') > 0) {
            $tags[] = substr($version, 0, strpos($version, '.'));
        }
        $tags[] = $version;

        return $tags;
    }

    /**
     * Files must contain an index entry, detailing any number of manual tags
     * each of these tags is extracted and added to the general tag structure for the file
     *
     * @param array $file file content, each line is an array item
     *
     * @return array extracted tags
     * @throws \InvalidArgumentException
     */
    protected function extractTagsFromFile(array $file) : array
    {
        foreach ($file as $index => $line) {
            if (StringUtility::beginsWith($line, '.. index::')) {
                $tagString = substr($line, strlen('.. index:: '));

                return GeneralUtility::trimExplode(',', $tagString, true);
            }
        }

        return [];
    }

    /**
     * Files contain a headline (provided as input parameter,
     * it starts with the category string.
     * This will used as a tag
     *
     * @param string $headline
     *
     * @return string
     */
    protected function extractCategoryFromHeadline(string $headline) : string
    {
        if (strpos($headline, ':') !== false) {
            return substr($headline, 0, strpos($headline, ':'));
        }

        return '';
    }

    /**
     * first line is headline mark, skip it
     * second line is headline
     *
     * @param array $lines
     *
     * @return string
     */
    protected function extractHeadline(array $lines) : string
    {
        return trim($lines[1]);
    }

    /**
     * @param string $headline
     *
     * @return int
     */
    protected function extractIssueNumber(string $headline) : int
    {
        return (int)substr($headline, strpos($headline, '#') + 1, 5);
    }

    /**
     * @param string $file
     * @param string $version
     * @param string $filename
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    protected function getListEntry(string $file, string $version, string $filename) : array
    {
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $headline = $this->extractHeadline($lines);
        $entry['headline'] = $headline;
        $entry['filepath'] = $file;
        $entry['link'] = sprintf(self::LINK_TEMPLATE, $version, $filename);
        $entry['tags'] = $this->extractTags($version, $lines);
        $entry['tagList'] = implode(',', $entry['tags']);
        $issueNumber = $this->extractIssueNumber($headline);

        return [$issueNumber => $entry];
    }

    /**
     * @param string $versionDirectory
     * @param string $version
     *
     * @return bool
     */
    protected function isRelevantDirectory(string $versionDirectory, string $version) : bool
    {
        return is_dir($versionDirectory) && $version !== '.' && $version !== '..';
    }

    /**
     * @param string $docDirectory
     * @param string $version
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    protected function getDocumentationFilesForVersion(
        string $docDirectory,
        string $version
    ) : array
    {
        $documentationFiles = [];
        if ($this->isRelevantDirectory($docDirectory, $version)) {
            $documentationFiles[$version] = [];
            $absolutePath = dirname($docDirectory) . DIRECTORY_SEPARATOR . $version;
            $rstFiles = scandir($docDirectory);
            foreach ($rstFiles as $file) {
                $fileInfo = pathinfo($file);
                if ($this->isRelevantFile($fileInfo)) {
                    $filePath = $absolutePath . DIRECTORY_SEPARATOR . $fileInfo['basename'];
                    $documentationFiles[$version] += $this->getListEntry($filePath, $version,
                        $fileInfo['filename']);
                }
            }
        }

        return $documentationFiles;
    }

    /**
     * @param $documentationFiles
     *
     * @return array
     */
    protected function collectTagTotal($documentationFiles) : array
    {
        $tags = [];
        foreach ($documentationFiles as $versionArray) {
            foreach ($versionArray as $fileArray) {
                $tags = array_merge(array_unique($tags), $fileArray['tags']);
            }
        }

        return array_unique($tags);
    }

    /**
     * @return array
     */
    public function getTagsTotal() : array
    {
        return $this->tagsTotal;
    }
}
