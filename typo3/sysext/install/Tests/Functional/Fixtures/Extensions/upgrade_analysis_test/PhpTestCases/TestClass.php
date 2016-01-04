<?php
namespace ABS\UpgradeAnalysisTest\PhpTestCases;

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
use TYPO3\CMS\Recycler\Utility\RecyclerUtility;

/**
 * Class contains code to deprecated methods, classes or other constructs
 *
 * Purpose: let those occurences be found by upgrade analysis tool
 */
class TestClass
{

    /**
     * belongs to Breaking-72334-RemovedUtf8ConversionInEXTrecycler.rst
     */
    public function removeUtf8ConversionInExtRecycler_72334_TestCase()
    {
        RecyclerUtility::getUtf8String();
        RecyclerUtility::isNotUtf8Charset();
        RecyclerUtility::getCurrentCharset();
    }
}
