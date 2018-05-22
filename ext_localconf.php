<?php
defined('TYPO3_MODE') or die();

if (TYPO3_MODE === 'BE') {
    // Add default typoscript setup
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
        '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:privacy/Configuration/TypoScript/BackendModul/setup.txt">'
    );
}
