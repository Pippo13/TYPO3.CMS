<?php
declare(strict_types = 1);
namespace TYPO3\CMS\Install\UpgradeAnalysis\Finder;
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
/**
 * Interface must be implemented by Upgrade Analysis Finder Classes
 */
interface UpgradeAnalysisFinderInterface {

    /**
     * Main finder method
     *
     * Indicates whether an instance is affected by given issue
     *
     * @return array
     */
    public function find() : array ;
}
