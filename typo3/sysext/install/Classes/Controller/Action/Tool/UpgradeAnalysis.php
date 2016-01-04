<?php
namespace TYPO3\CMS\Install\Controller\Action\Tool;

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
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Install\Controller\Action\AbstractAction;
use TYPO3\CMS\Install\UpgradeAnalysis\DocumentationFileService;

/**
 * run code analysis based on changelog documentation
 */
class UpgradeAnalysis extends AbstractAction
{



    /**
     * Executes the action
     *
     * @return string|array Rendered content
     */
    protected function executeAction()
    {
        $documentationFileService = new DocumentationFileService();
        $documentationFiles = $documentationFileService->findDocumentationFiles(
            PATH_site . ExtensionManagementUtility::siteRelPath('core') . 'Documentation/Changelog'
        );
        $tagsTotal = $documentationFileService->getTagsTotal();

        $this->view->assign('files', $documentationFiles);
        $this->view->assign('tagCloud', $tagsTotal);
        return $this->view->render();
    }

}
