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

use TYPO3\CMS\Install\UpgradeAnalysis\Finder\UpgradeAnalysisFinderInterface;

/**
 * Provides details about Finder Classes
 */
class FinderService
{

    /**
     * @var FinderRegistry
     */
    protected $finderRegistry;

    /**
     * FinderService constructor.
     *
     * @param FinderRegistry $finderRegistry
     */
    public function __construct(FinderRegistry $finderRegistry)
    {
        $this->finderRegistry = $finderRegistry;
    }

    /**
     * @param array $documentationFiles [key => classname]
     *
     * @return array instantiated finder classes keyed by issueNumber
     * @throws \InvalidArgumentException
     */
    public function getInstantiatedFinderClasses(array $documentationFiles) : array
    {
        $finderClasses = [];
        foreach ($documentationFiles as $version => $files) {
            foreach ($files as $issueNumber => $_file) {
                $finderClass = $this->finderRegistry->instantiate($issueNumber);
                if ($finderClass instanceof UpgradeAnalysisFinderInterface) {
                    $finderClasses[$issueNumber] = $finderClass;
                }
            }
        }

        return $finderClasses;
    }

    /**
     * Array of matches returned for provided finder instances
     *
     * @param array $finderClasses
     *
     * @return array
     */
    public function find(array $finderClasses) : array
    {
        $matches = [];
        /** @var UpgradeAnalysisFinderInterface $finderClass */
        foreach ($finderClasses as $issueNumber => $finderClass) {
            $match = $finderClass->find();
            if (count($match) !== 0) {
                $matches[$issueNumber] = $match;
            }
        }

        return $matches;
    }
}
