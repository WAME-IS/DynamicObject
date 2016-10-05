<?php

namespace Wame\DynamicObject\Renderers;

use Nette;
use Nette\Forms\Rendering\DefaultFormRenderer;
use Nette\Utils\Html;
use Wame\DynamicObject\Forms\Containers\BaseContainer;
use Wame\DynamicObject\Forms\Groups\BaseGroup;

class TemplateFormRenderer extends DefaultFormRenderer
{
    use \Wame\DynamicObject\Traits\TLink;
    
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
        
        echo '<div class="row">';
        
        foreach ($this->form->getBaseGroups() as $group) {
            echo $group->getTag()->startTag();
            
            $text = $group->getText();
            if ($text instanceof Html) {
                $label = $this->getWrapper('group label')->addHtml($text);
                
                foreach($group->getButtons() as $button) {
                    $label->addHtml($this->renderButton($button, $group));
                }
                
                echo $label;
            } elseif (is_string($text)) {
                if ($translator !== NULL) {
                    $text = $translator->translate($text);
                }
                $label = $this->getWrapper('group label')->setHtml($text);
                
                foreach($group->getButtons() as $button) {
                    $label->addHtml($this->renderButton($button, $group));
                }
                
                echo $label;
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
            
            
            
            echo $group->getTag()->endTag();
        }
        echo '</div>';
        
    }
    
    
    /**
     * Render button
     * 
     * @param array $button     button
     * @param BaseGroup $group  group
     * @return Html
     */
    private function renderButton($button, $group)
    {
        $el = Html::el("a");
        
        $el->addAttributes([
            'href' => $this->createLink($group, $button['href'], $button['params']),
            'class' => 'btn btn-link pull-right ajax-modal ajax-modal-fixed'
        ]);
        
        if($button['icon']) {
            $el->add(Html::el("i")
                ->addClass('material-icons')
                ->addText($button['icon']));
        }
        
        $el->add($button['text']);
        
        return $el;
    }
    
}
