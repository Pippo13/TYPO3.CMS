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

namespace TYPO3\CMS\Install\Controller\Action\Ajax;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Install\UpgradeAnalysis\DocumentationFileService;
use TYPO3\CMS\Install\UpgradeAnalysis\FinderRegistry;
use TYPO3\CMS\Install\UpgradeAnalysis\FinderService;

/**
 * ${DESCRIPTION}
 */
class UpgradeAnalysis extends AbstractAjaxAction
{

    /**
     * @var FinderService
     */
    protected $finderService;

    /**
     * @var DocumentationFileService
     */
    protected $documentationFileService;

    /**
     * all used tags to build the filters from
     *
     * @var array
     */
    protected $tagsTotal = [];

    /**
     * @var array
     */
    protected $documentationFiles = [];

    /**
     * @var array
     */
    protected $finderClasses = [];

    /**
     * Executes the action
     *
     * @return string|array Rendered content
     */
    protected function executeAction() : string
    {
        $getVars = \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('install');
        if (!isset($getVars['type'])) {
            $type = 'listDocumentation';
        } else {
            $type = $getVars['type'];
        }

        $this->documentationFileService = new DocumentationFileService();
        $this->finderService = new FinderService(new FinderRegistry());

        $tagsTotal = $this->documentationFileService->getTagsTotal();

        $this->view->assign('tagCloud', $tagsTotal);
        $this->view->assign('type', ucfirst($type));

        return $this->$type();
    }

    /**
     * @return string
     */
    protected function listDocumentation() : string
    {

        $this->documentationFiles = $this->documentationFileService->findDocumentationFiles(
            PATH_site . ExtensionManagementUtility::siteRelPath('core') . 'Documentation/Changelog'
        );
        $this->tagsTotal = $this->documentationFileService->getTagsTotal();
        $this->finderClasses = $this->finderService->getInstantiatedFinderClasses($this->documentationFiles);

        $this->view->assign('files', $this->documentationFiles);
        $this->view->assign('finderClasses', $this->finderClasses);

        return $this->view->render();
    }

    /**
     * @return string
     * @throws \InvalidArgumentException
     */
    protected function filterAffection() : string
    {

        if (count($this->documentationFiles) === 0) {
            $this->documentationFiles = $this->documentationFileService->findDocumentationFiles(
                PATH_site . ExtensionManagementUtility::siteRelPath('core') . 'Documentation/Changelog'
            );
            $this->tagsTotal = $this->documentationFileService->getTagsTotal();
        }
        if (count($this->finderClasses) === 0) {
            $this->finderClasses = $this->finderService->getInstantiatedFinderClasses($this->documentationFiles);
        }
        $matches = $this->finderService->find($this->finderClasses);

        $this->view->assign('files', $this->documentationFiles);
        $this->view->assign('finderClasses', $this->finderClasses);
        $this->view->assign('matches', $matches);

        return $this->view->render();
    }
}
