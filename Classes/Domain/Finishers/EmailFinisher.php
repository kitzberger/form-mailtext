<?php
declare(strict_types = 1);
namespace Kitzberger\FormMailtext\Domain\Finishers;

use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Form\Domain\Runtime\FormRuntime;

class EmailFinisher extends \TYPO3\CMS\Form\Domain\Finishers\EmailFinisher
{
    /**
     * @param FormRuntime $formRuntime
     * @return StandaloneView
     * @throws FinisherException
     */
    protected function initializeStandaloneView(FormRuntime $formRuntime): StandaloneView
    {
    	$standaloneView = parent::initializeStandaloneView($formRuntime);

    	$standaloneView->assign('message', $this->parseOption('message'));

        return $standaloneView;
    }
}
