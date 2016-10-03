<?php

namespace Wame\DynamicObject\Renderers;

use Nette;
use Nette\Forms\Rendering\DefaultFormRenderer;
use Nette\Utils\Html;
use Wame\DynamicObject\Forms\Containers\BaseContainer;
use Wame\DynamicObject\Forms\Groups\BaseGroup;

class TemplateFormRenderer extends DefaultFormRenderer
{
    /** {@inheritDoc} */
    public function render(Nette\Forms\Form $form, $mode = NULL)
    {
        if ($this->form !== $form) {
			$this->form = $form;
		}
        
        $this->form->getElementPrototype()->addAttributes(['class' => 'ajax']);
        
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
        $defaultContainer = $this->getWrapper('group container');
        $translator = $this->form->getTranslator();

        foreach ($this->form->getGroups() as $group) {
//            if (!$group->getControls() || !$group->getOption('visual')) {
//                continue;
//            }

            \Tracy\Debugger::barDump($group);
            
            if($group instanceof BaseGroup) {
                \Tracy\Debugger::barDump($group->getGroupTag());
            }
            
            echo ($group instanceof BaseGroup) ? $group->getGroupTag()->startTag() : $defaultContainer->startTag();

            $text = $group->getOption('label');
            if ($text instanceof Html) {
                echo $this->getWrapper('group label')->addHtml($text);

            } elseif (is_string($text)) {
                if ($translator !== NULL) {
                    $text = $translator->translate($text);
                }
                echo "\n" . $this->getWrapper('group label')->setHtml($text) . "\n";
            }

            $text = $group->getOption('description');
            if ($text instanceof Html) {
                echo $text;

            } elseif (is_string($text)) {
                if ($translator !== NULL) {
                    $text = $translator->translate($text);
                }
                echo $this->getWrapper('group description')->setText($text) . "\n";
            }

            foreach($this->form->components as $component) {
                if($component instanceof BaseContainer && $component->currentGroup == $group) {
                    $component->render();
                }
            }

            echo ($group instanceof BaseGroup) ? $group->getGroupTag()->endTag() : $defaultContainer->endTag();
        }
    }
    
}
