<?php
defined('TYPO3_MODE') or die();

call_user_func(function () {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
        trim('
            plugin.tx_form {
                settings {
                    yamlConfigurations {
                        100 = EXT:form_mailtext/Configuration/Form/MailtextFormSetup.yaml
                    }
                }
            }
            module.tx_form {
                settings {
                    yamlConfigurations {
                        100 = EXT:form_mailtext/Configuration/Form/MailtextFormSetup.yaml
                    }
                }
            }
        ')
    );
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:form/Resources/Private/Language/Database.xlf'][] = 'EXT:form_mailtext/Resources/Private/Language/Database.xlf';

    # Override EmailFinisher with slightly different one (that handles 'message' field)
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Form\Domain\Finishers\EmailFinisher::class] = [
        'className' => \Kitzberger\FormMailtext\Domain\Finishers\EmailFinisher::class
    ];
});
