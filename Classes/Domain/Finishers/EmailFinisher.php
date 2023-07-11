<?php
declare(strict_types = 1);
namespace Kitzberger\FormMailtext\Domain\Finishers;

use TYPO3\CMS\Core\Mail\FluidEmail;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Form\Domain\Runtime\FormRuntime;

class EmailFinisher extends \TYPO3\CMS\Form\Domain\Finishers\EmailFinisher
{
    /**
     * @param FormRuntime $formRuntime
     * @param string $format
     * @return StandaloneView
     * @throws FinisherException
     */
    protected function initializeStandaloneView(FormRuntime $formRuntime, string $format): StandaloneView
    {
        $standaloneView = parent::initializeStandaloneView($formRuntime, $format);

        $message = $this->parseMessage();
        $formValues = $formRuntime->getFormState()->getFormValues();
        #debug($formValues, 'formValues');
        #debug($message, 'message (before)');
        $message = $this->replaceIfs($message, $formValues);
        #debug($message, 'message (after)');
        #die();
        $standaloneView->assign('message', $message);

        return $standaloneView;
    }

    protected function initializeFluidEmail(FormRuntime $formRuntime): FluidEmail
    {
        $fluidEmail = parent::initializeFluidEmail($formRuntime);

        $message = $this->parseMessage();
        $formValues = $formRuntime->getFormState()->getFormValues();
		$message = $this->replaceIfs($message, $formValues);

        $fluidEmail->assign('message', $message);

        return $fluidEmail;
    }

    protected function parseMessage()
    {
        $message = $this->parseOption('message');
        if (empty($message)) {
            $message = '{variables}';
        }
        return $message;
    }


    private function replaceIfs($message, $formValues)
    {
        return preg_replace_callback(
            '/{if:([a-z0-9\-_]+):([^:]+):([a-z0-9\-_,]*)}(.*)({endif})/isU',
            function($match) use ($formValues) {
                #debug($match, 'a match!');

                $operandOne = $match[1];
                $operation  = $match[2];
                $operandTwo = $match[3];

                list($thenValue, $elseValue) = GeneralUtility::trimExplode('{else}', $match[4], true);
                #debug([$thenValue, $elseValue]);

                if (isset($formValues[$operandOne])) {
                    $operandOneValue = $formValues[$operandOne];
                }
                if (isset($formValues[$operandTwo])) {
                    $operandTwoValue = $formValues[$operandTwo];
                } else {
                    $operandTwoValue = $operandTwo;
                }

                switch ($operation) {
                    case '=':
                    case '==':
                    case '===':
                        if ($operandOneValue == $operandTwoValue) {
                            return $thenValue;
                        }
                        return $elseValue ?? '';
                    case '>':
                    case '&gt;':
                        if ($operandOneValue > $operandTwoValue) {
                            return $thenValue;
                        }
                        return $elseValue ?? '';
                    case '<':
                    case '&lt;':
                        if ($operandOneValue < $operandTwoValue) {
                            return $thenValue;
                        }
                        return $elseValue ?? '';
                    case '!=':
                    case '<>':
                    case '&lt;&gt;':
                        if ($operandOneValue != $operandTwoValue) {
                            return $thenValue;
                        }
                        return $elseValue ?? '';
                    case 'in':
                        // example: {if:multicheckbox-1:in:dog,cat}

                        if (!is_array($operandOneValue)) {
                            $operandOneValue = [$operandOneValue];
                        }
                        $operandTwoValue = GeneralUtility::trimExplode(',', $operandTwoValue, true);

                        foreach ($operandOneValue as $value) {
                            if (in_array($value, $operandTwoValue)) {
                                return $thenValue;
                            }
                        }

                        return $elseValue ?? '';
                }
            },
            $message
		);
	}
}
