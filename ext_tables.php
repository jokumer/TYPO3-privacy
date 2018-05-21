<?php
defined('TYPO3_MODE') or die();

if (TYPO3_MODE === 'BE') {
    // Backend modul
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'Jokumer.Privacy',
        'web',
        'privacy',
        'bottom',
        [
            'BackendModul' => 'listApplications, listSubjects, anonymizeSubject, exportSubject, deleteSubject, viewSubject',
        ],
        [
            'access' => 'user,group',
            'icon' => 'EXT:privacy/Resources/Public/Icons/BackendModul.svg',
            'labels' => 'LLL:EXT:privacy/Resources/Private/Language/locallang_modul.xlf',
            'navigationComponentId' => '',
            'inheritNavigationComponentFromMainModule' => false
        ]
    );
}
