<?php
declare(strict_types = 1);
namespace TYPO3\CMS\Install\UpgradeAnalysis;

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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Install\UpgradeAnalysis\Finder\Php\Finders\RemoveUtf8ConversionInExtRecycler;

/**
 * Registry for Finder classes matched by issue number
 */
class FinderRegistry
{

    /**
     * Default Registry of issue numbers handled by finder classes
     *
     * @var array
     */
    protected $finderClasses = [
        72334 => RemoveUtf8ConversionInExtRecycler::class,
    ];

    /**
     * @param int $issueNumber the issueNumber the wanted finder class is registered with
     *
     * @return object instantiated finder class
     * @throws \InvalidArgumentException
     */
    public function instantiate($issueNumber)
    {
        $className = $this->finderClasses[$issueNumber];
        if ($className !== null && strlen($className) > 0) {
            return GeneralUtility::makeInstance($this->finderClasses[$issueNumber]);
        }
        return null;
    }
}
