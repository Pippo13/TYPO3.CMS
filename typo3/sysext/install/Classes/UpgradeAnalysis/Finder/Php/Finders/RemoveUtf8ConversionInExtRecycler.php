<?php
declare(strict_types = 1);
namespace TYPO3\CMS\Install\UpgradeAnalysis\Finder\Php\Finders;

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
use TYPO3\CMS\Install\UpgradeAnalysis\Finder\Php\AbstractPhpIssueFinder;

/**
 * Detecting of issue 72334
 */
class RemoveUtf8ConversionInExtRecycler extends AbstractPhpIssueFinder
{

    /**
     * Token sequence for Issue 72334
     *
     * @var array
     */
    protected $sequences = [
        [
            [T_STRING, 'RecyclerUtility'],
            [T_DOUBLE_COLON],
            [T_STRING, 'getUtf8String'],
            '(',
        ],
        [
            [T_STRING, 'RecyclerUtility'],
            [T_DOUBLE_COLON],
            [T_STRING, 'isNotUtf8Charset'],
            '(',
        ],
        [
            [T_STRING, 'RecyclerUtility'],
            [T_DOUBLE_COLON],
            [T_STRING, 'getCurrentCharset'],
            '(',
        ],
    ];


}
