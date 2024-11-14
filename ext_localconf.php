<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Form\Domain\Finishers\EmailFinisher;

defined('TYPO3') or die();

call_user_func(function () {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:form/Resources/Private/Language/Database.xlf'][] = 'EXT:form_mailtext/Resources/Private/Language/Database.xlf';

    # Override EmailFinisher with slightly different one (that handles 'message' field)
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][EmailFinisher::class] = [
        'className' => \Kitzberger\FormMailtext\Domain\Finishers\EmailFinisher::class
    ];

    // Add module configuration
    ExtensionManagementUtility::addTypoScriptSetup(
        'module.tx_form {
    settings {
        yamlConfigurations {
            105 = EXT:form_mailtext/Configuration/Form/MailtextFormSetup.yaml
        }
    }
}'
    );
});
