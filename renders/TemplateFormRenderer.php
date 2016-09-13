<?php

namespace Wame\DynamicObject\Renderers;

use Nette;
use Nette\Forms\Rendering\DefaultFormRenderer;
use Wame\DynamicObject\Forms\Containers\BaseContainer;

class TemplateFormRenderer extends DefaultFormRenderer
{
    /** {@inheritDoc} */
    public function render(Nette\Forms\Form $form, $mode = NULL)
    {
        if ($this->form !== $form) {
			$this->form = $form;
		}
        
        if (!$mode || $mode === 'begin') {
			echo $this->renderBegin();
		}
		if (!$mode || strtolower($mode) === 'ownerrors') {
			echo $this->renderErrors();

		} elseif ($mode === 'errors') {
			echo $this->renderErrors(NULL, FALSE);
		}
		if (!$mode || $mode === 'body') {
			echo $this->renderBody();
		}
		if (!$mode || $mode === 'end') {
			echo $this->renderEnd();
		}
    }
    
    /** {@inheritDoc} */
    public function renderBody()
    {
        foreach($this->form->components as $component) {
            if($component instanceof BaseContainer) {
                $component->render();
            }
        }
    }
    
}
