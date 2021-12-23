<?php
defined('TYPO3') or die();

call_user_func(function () {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:form/Resources/Private/Language/Database.xlf'][] = 'EXT:form_mailtext/Resources/Private/Language/Database.xlf';

    # Override EmailFinisher with slightly different one (that handles 'message' field)
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Form\Domain\Finishers\EmailFinisher::class] = [
        'className' => \Kitzberger\FormMailtext\Domain\Finishers\EmailFinisher::class
    ];
});
