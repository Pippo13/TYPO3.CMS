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
namespace TYPO3\CMS\Install\UpgradeAnalysis\Finder\Php;

use Symfony\Component\Finder\SplFileInfo;
use Symfony\CS\Finder\DefaultFinder;
use Symfony\CS\Tokenizer\Tokens;
use TYPO3\CMS\Install\UpgradeAnalysis\Finder\UpgradeAnalysisFinderInterface;

/**
 * Abstract class providing a finder method based on the sequences
 * detailed in the concrete classes
 */
abstract class AbstractPhpIssueFinder implements UpgradeAnalysisFinderInterface
{

    /**
     * Token sequences attended by the concrete finder class
     *
     * @var array
     */
    protected $sequences = [];

    /**
     * Directory path to be scanned recursively
     *
     * @var string
     */
    protected $directoryToBeScanned = '';

    /**
     * Set path to directory to be scanned
     *
     * @param string $directory
     */
    public function setDirectoryToBeScanned($directory)
    {
        $this->directoryToBeScanned = $directory;
    }

    /**
     * Main finder method
     *
     * Indicates whether an instance is affected by given issue
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    public function find() : array
    {
        if ($this->directoryToBeScanned === '') {
            $this->setDirectoryToBeScanned(PATH_site . 'typo3conf/ext');
        }

        $result = [];

        /** @var DefaultFinder $finder */
        $finder = new DefaultFinder();
        $finder->files()
            ->in($this->directoryToBeScanned)
            ->ignoreDotFiles(true)
            ->ignoreVCS(true)
            ->name('*.php');

        /** @var SplFileInfo $fileInfo */
        foreach ($finder as $fileInfo) {
            $file = $fileInfo->getRealPath();
            if (is_dir($file) || is_link($file)) {
                continue;
            }
            $content = file_get_contents($file);

            /** @var Tokens $tokens */
            $tokens = Tokens::fromCode($content);

            foreach ($this->sequences as $sequence) {
                $match = $tokens->findSequence($sequence);
                if ($match !== null) {
                    $match['file'] = 'ext:' . $fileInfo->getRelativePathname();
                    $result[] = $match;
                }
            }
        }

        return $result;
    }
}
