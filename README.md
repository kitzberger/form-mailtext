# TYPO3 Extension form\_mailtext

This extension enhances the email finishers of EXT:form by a new field 'Mail text' (`message`) that allows the editor to define the mail text within the form plugin in the backend:

![Form plugin](./Resources/Public/Images/Plugin.png "Form plugin in TYPO3 BE")

## EmailFinisher override

For this to work the email finisher class of EXT:form is being overridden by our [EmailFinisher](./Classes/Domain/Finishers/EmailFinisher.php), so the `message` variable can be passed through to the template [Finishers/Email/Html.html](./Resources/Private/Frontend/Templates/Finishers/Email/Html.html) where it's being processed by [RenderMessageViewHelper](./Classes/ViewHelpers/RenderMessageViewHelper.php) and rendered to all created emails.

## TypoScript

The following TS setup is added automatically via [ext\_typoscript\_setup.typoscript](./ext_typoscript_setup.typoscript):

```
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
```
