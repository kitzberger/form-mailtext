<?php
declare(strict_types = 1);
namespace Kitzberger\FormMailtext\Domain\Finishers;

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

        $message = $this->parseOption('message');
        $formValues = $formRuntime->getFormState()->getFormValues();
        #debug($formValues, 'formValues');
        #debug($message, 'message (before)');
        $message = $this->replaceIfs($message, $formValues);
        #debug($message, 'message (after)');
        #die();
        $standaloneView->assign('message', $message);

        return $standaloneView;
    }

    private function replaceIfs($message, $formValues)
    {
        return preg_replace_callback(
            '/{if:([a-z0-9\-_]+):(.+):([a-z0-9\-_]+)}(.*)({endif})/sU',
            function($match) use ($formValues) {
                #debug($match, 'a match!');

                $operandOne = $match[1];
                $operation  = $match[2];
                $operandTwo = $match[3];

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
                            return $match[4];
                        } else {
                            return '';
                        }
                    case '>':
                    case '&gt;':
                        if ($operandOneValue > $operandTwoValue) {
                            return $match[4];
                        } else {
                            return '';
                        }
                    case '<':
                    case '&lt;':
                        if ($operandOneValue < $operandTwoValue) {
                            return $match[4];
                        } else {
                            return '';
                        }
                    case '!=':
                    case '<>':
                    case '&lt;&gt;':
                        if ($operandOneValue != $operandTwoValue) {
                            return $match[4];
                        } else {
                            return '';
                        }
                }
            },
            $message
        );
    }
}
