<?php
$EM_CONF[$_EXTKEY] = array(
    'title' => 'Context Sensitive Help',
    'description' => 'Provides context sensitive help to tables, fields and modules in the system languages.',
    'category' => 'be',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'author' => 'Kasper Skaarhoj',
    'author_email' => 'kasperYYYY@typo3.com',
    'author_company' => 'Curby Soft Multimedia',
    'version' => '8.1.0',
    'constraints' => array(
        'depends' => array(
            'typo3' => '8.1.0-8.1.99',
        ),
        'conflicts' => array(),
        'suggests' => array(),
    ),
);
