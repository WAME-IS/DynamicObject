<?php

namespace Wame\DynamicObject\Renderers;

use Nette;
use Nette\Forms\Rendering\DefaultFormRenderer;
use Nette\Utils\Html;
use Wame\DynamicObject\Forms\Containers\BaseContainer;
use Wame\DynamicObject\Forms\Groups\BaseGroup;

class TemplateFormRenderer extends DefaultFormRenderer
{
    protected $translator;
    
    
    use \Wame\DynamicObject\Traits\TLink;
    
    
    /** {@inheritDoc} */
    public function render(Nette\Forms\Form $form, $mode = NULL)
    {
        if ($this->form !== $form) {
			$this->form = $form;
		}
        
//        $this->form->getElementPrototype()->addAttributes(['class' => 'ajax']);
        
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
        $this->translator = $this->form->getTranslator();
        
        $this->renderTabs();
    }
    
    
    private function renderTabs()
    {
        echo '<div class="form-tabs">';
            echo '<ul class="tabs">';
                foreach ($this->form->getBaseTabs() as $t) {
                    echo '<li class="tab"><a href="#'.$t->getText().'">' . $t->getText() . '</a></li>';
                }
            echo '</ul>';
        echo '</div>';
        
        foreach ($this->form->getBaseTabs() as $tab) {
            echo $tab->setAttribute('id', $tab->getText())->getTag()->startTag();
                echo '<div class="row">';
                    $this->renderGroups($tab);
                echo '</div>';
            echo $tab->getTag()->endTag();
        }
    }
    
    private function renderGroups($tab = null)
    {
        foreach ($this->form->getBaseGroups() as $group) {
                $components = [];
                
                foreach($this->form->components as $component) {
                    if($component instanceof BaseContainer && $component->currentGroup == $group && $component->currentTab == $tab) {
                        $components[] = $component;
                    }
                }
                
                if(count($components) > 0) {
                    $this->renderGroup($group, $components);
                }
            }
    }
    
    private function renderGroup($group, $components)
    {
        $container = Html::el('div')->addAttributes($group->getAttributes());
        
        echo $container->addClass('group')->addClass($group->getWidth())->startTag();
        echo $group->getTag()->startTag();

        $text = $group->getText();
        if ($text instanceof Html) {
            $label = $this->getWrapper('group label')->addHtml($text);

            foreach($group->getButtons() as $button) {
                $label->addHtml($this->renderButton($button, $group));
            }

            echo $label;
        } elseif (is_string($text)) {
            if ($this->translator !== NULL) {
                $text = $this->translator->translate($text);
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
            if ($this->translator !== NULL) {
                $text = $this->translator->translate($text);
            }
            echo $this->getWrapper('group description')->setText($text) . "\n";
        }

        $this->renderComponents($components);
        
        echo $group->getTag()->endTag();
        echo $container->endTag();
    }
    
    private function renderComponents($components)
    {
        foreach($components as $component) {
            $component->render();
        }
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
