<?php
$EM_CONF[$_EXTKEY] = array(
    'title' => 'Upgrade Analysis Test Extension',
    'description' => 'contains cases of deprecated code, old fashioned styles and such.',
    'category' => 'be',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'author' => 'Anja Leichsenring',
    'author_email' => 'anja.leichsenring@typo3.org',
    'author_company' => '',
    'version' => '1.0.0',
    'constraints' => array(
        'depends' => array(
            'typo3' => '8.0.0-8.0.99',
        ),
        'conflicts' => array(),
        'suggests' => array(),
    ),
);
