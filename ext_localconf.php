<?php
defined('TYPO3_MODE') or die();

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['privacy']['applications'] = [
    'frontenduser' => [
        'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:fe_users',
        'table' => 'fe_users',
        'fieldProcessing' => [
            'anonymize' => [
                'username',
                'email'
            ],
            'export' => [
                'username',
                'email'
            ]
        ]
    ],
    'backenduser' => [
        'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:be_users',
        'table' => 'be_users',
        'fieldProcessing' => [
            'anonymize' => [
                'username',
                'email'
            ],
            'export' => [
                'username',
                'email'
            ]
        ]
    ]
];
