<?php

namespace Wame\DynamicObject\Forms;

use Nette\Application\UI\Form;

class BaseForm extends Form
{
    /** @var bool */
    private $useRenderer = false;
    
    
    /** {@inheritDoc} */
    protected function attached($presenter)
    {
        parent::attached($presenter);
        
        foreach($this->components as $component) {
            if($component instanceof Containers\BaseContainer) {
                $component->render();
            }
        }
    }
    
    /** {@inheritDoc} */
    public function render()
    {
        if($this->useRenderer) {
            parent::render();
        }
    }
    
}