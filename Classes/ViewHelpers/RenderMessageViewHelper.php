<?php
declare(strict_types = 1);
namespace Kitzberger\FormMailtext\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Form\Domain\Model\Renderable\RootRenderableInterface;

class RenderMessageViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Initialize the arguments.
     *
     * @internal
     */
    public function initializeArguments()
    {
        $this->registerArgument('message', 'string', 'The message definied in the plugin', false);
    }

    /**
     * Renders the message (incl. the variables)
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string the rendered form values
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $message = $arguments['message'];

        // replace {variables} by the child content of this viewhelper
        $message = preg_replace('/(<p>)?{variables}(<\/p>)?/', $renderChildrenClosure(), $message);

        return $message;
    }
}
