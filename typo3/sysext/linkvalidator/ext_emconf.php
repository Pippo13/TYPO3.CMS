<?php
$EM_CONF[$_EXTKEY] = array(
    'title' => 'Link Validator',
    'description' => 'Link Validator checks the links in your website for validity. It can validate all kinds of links: internal, external and file links. Scheduler is supported to run Link Validator via Cron including the option to send status mails, if broken links were detected.',
    'category' => 'module',
    'author' => 'Jochen Rieger / Dimitri König / Michael Miousse',
    'author_email' => 'j.rieger@connecta.ag, mmiousse@infoglobe.ca',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'author_company' => 'Connecta AG / cab services ag / Infoglobe',
    'version' => '8.1.0',
    'constraints' => array(
        'depends' => array(
            'typo3' => '8.1.0-8.1.99',
            'info' => '8.1.0-8.1.99',
        ),
        'conflicts' => array(),
        'suggests' => array(),
    ),
);
