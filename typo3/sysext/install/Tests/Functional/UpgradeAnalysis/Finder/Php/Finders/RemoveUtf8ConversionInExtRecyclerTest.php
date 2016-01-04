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

namespace TYPO3\CMS\Install\Tests\Functional\UpgradeAnalysis\Finder\Php\Finders;

use TYPO3\CMS\Install\UpgradeAnalysis\Finder\Php\Finders\RemoveUtf8ConversionInExtRecycler;

class RemoveUtf8ConversionInExtRecyclerTest extends \TYPO3\CMS\Core\Tests\FunctionalTestCase
{

    protected $testExtensionsToLoad = [
        'typo3/sysext/install/Tests/Functional/Fixtures/Extensions/upgrade_analysis_test'
    ];

    /**
     * @test
     */
    public function findReturnsMatchesCorrectly()
    {
        $instance = new RemoveUtf8ConversionInExtRecycler();
        $instance->setDirectoryToBeScanned($this->testExtensionsToLoad[0]);
        $result = $instance->find();
        self::assertCount(3, $result);
        foreach ($result as $match) {
            $expected = 'ext:PhpTestCases/TestClass.php';
            $actual = $match['file'];
            self::assertEquals($expected, $actual);
        }
    }
}
