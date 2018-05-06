<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Privacy manager',
    'description' => 'Manage compliance rules for TYPO3 to improve privacy and to grant the EU General Data Protection Regulation (GDPR)',
    'category' => 'module',
    'author' => 'JKummer, prathers',
    'author_email' => 'service@enobe.de',
    'state' => 'alpha',
    'clearCacheOnLoad' => 0,
    'version' => '0.1.0',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-8.7.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ]
    ],
    'autoload' => [
        'psr-4' => [
            'Jokumer\\Privacy\\' => 'Classes',
        ],
    ]
];
