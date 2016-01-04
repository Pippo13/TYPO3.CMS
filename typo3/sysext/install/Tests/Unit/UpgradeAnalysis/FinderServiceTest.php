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

namespace TYPO3\CMS\Install\Tests\Unit\UpgradeAnalysis;

use Prophecy\Prophecy\ObjectProphecy;
use TYPO3\CMS\Install\UpgradeAnalysis\Finder\UpgradeAnalysisFinderInterface;
use TYPO3\CMS\Install\UpgradeAnalysis\FinderRegistry;
use TYPO3\CMS\Install\UpgradeAnalysis\FinderService;

class FinderServiceTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

    /**
     * @test
     */
    public function getInstantiatedFinderClassesReturnsInstances()
    {
        /** @var UpgradeAnalysisFinderInterface|ObjectProphecy $finderInstance */
        $finderInstance = self::prophesize(UpgradeAnalysisFinderInterface::class);
        /** @var FinderRegistry|ObjectProphecy $finderRegistry */
        $finderRegistry = self::prophesize(FinderRegistry::class);
        $issueNumber = 12345;
        $finderRegistry->instantiate($issueNumber)->willReturn($finderInstance->reveal());
        $documentationFiles = [
            '1.2' => [
                $issueNumber => [
                ],
            ]
        ];
        $finderService = new FinderService($finderRegistry->reveal());
        $instances = $finderService->getInstantiatedFinderClasses($documentationFiles);
        self::assertSame($finderInstance->reveal(), $instances[$issueNumber]);
    }

    /**
     * @test
     */
    public function findReturnsArrayOfMatches()
    {
        $issueNumber = 12345;
        /** @var UpgradeAnalysisFinderInterface|ObjectProphecy $finderInstance */
        $finderInstance = self::prophesize(UpgradeAnalysisFinderInterface::class);
        $finderInstance->find()->willReturn(['testFile' => 'ext:TestExtension/TestFile.php']);
        $instances = [
            $issueNumber => $finderInstance->reveal(),
        ];
        $expected = [
            $issueNumber => ['testFile' => 'ext:TestExtension/TestFile.php']
        ];
        $finderService = new FinderService(self::prophesize(FinderRegistry::class)->reveal());
        self::assertSame($expected, $finderService->find($instances));
    }
}
