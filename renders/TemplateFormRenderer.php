<?php

namespace Wame\DynamicObject\Renderers;

use Nette;
use Nette\Forms\Rendering\DefaultFormRenderer;

class TemplateFormRenderer extends DefaultFormRenderer
{
    /** {@inheritDoc} */
    public function render(Nette\Forms\Form $form, $mode = null)
    {
        \Tracy\Debugger::barDump($form);
        
//        foreach($form->getGroups() as $group) {
//            \Tracy\Debugger::barDump($group);
//            foreach($group as $container) {
//                \Tracy\Debugger::barDump($container);
//            }
//        }

        return parent::render($form, $mode);
    }
    
}
