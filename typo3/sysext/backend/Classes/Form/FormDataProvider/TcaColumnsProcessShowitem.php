<?php
namespace TYPO3\CMS\Backend\Form\FormDataProvider;

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

use TYPO3\CMS\Backend\Form\FormDataProviderInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Mark columns that are used in showitem or palettes for further processing
 */
class TcaColumnsProcessShowitem implements FormDataProviderInterface
{
    /**
     * Determine which fields are shown to the user and add those to the list of
     * columns that must be processed by the next data providers.
     *
     * @param array $result
     * @return array
     */
    public function addData(array $result)
    {
        $recordTypeValue = $result['recordTypeValue'];
        if (empty($result['processedTca']['types'][$recordTypeValue]['showitem'])
            || !is_string($result['processedTca']['types'][$recordTypeValue]['showitem'])
            || empty($result['processedTca']['columns'])
            || !is_array($result['processedTca']['columns'])
        ) {
            return $result;
        }

        $showItemFieldString = !empty($result['overruleTypesArray'][$recordTypeValue]['showitem'])
            ? $result['overruleTypesArray'][$recordTypeValue]['showitem']
            : $result['processedTca']['types'][$recordTypeValue]['showitem'];
        $showItemFieldArray = GeneralUtility::trimExplode(',', $showItemFieldString, true);

        foreach ($showItemFieldArray as $fieldConfigurationString) {
            $fieldConfigurationArray = GeneralUtility::trimExplode(';', $fieldConfigurationString);
            $fieldName = $fieldConfigurationArray[0];
            if ($fieldName === '--div--') {
                continue;
            }
            if ($fieldName === '--palette--') {
                if (isset($fieldConfigurationArray[2])) {
                    $paletteName = $fieldConfigurationArray[2];
                    if (!empty($result['processedTca']['palettes'][$paletteName]['showitem'])) {
                        $paletteFields = GeneralUtility::trimExplode(',', $result['processedTca']['palettes'][$paletteName]['showitem'], true);
                        foreach ($paletteFields as $paletteFieldConfiguration) {
                            $paletteFieldConfigurationArray = GeneralUtility::trimExplode(';', $paletteFieldConfiguration);
                            $result['columnsToProcess'][] = $paletteFieldConfigurationArray[0];
                        }
                    }
                }
            } else {
                $result['columnsToProcess'][] = $fieldName;
            }
        }

        return $result;
    }
}