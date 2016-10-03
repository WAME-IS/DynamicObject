<?php

namespace Wame\DynamicObject\Forms\Groups;

use Wame\DynamicObject\Forms\Containers\BaseContainer;
use Nette\Forms\ControlGroup;
use Nette\Utils\Html;

abstract class BaseGroup extends BaseContainer
{
    private $linkGenerator;
    
    
    public function __construct(\Nette\Application\LinkGenerator $linkGenerator) {
        parent::__construct();
        
        $this->linkGenerator = $linkGenerator;
    }
    
    /** {@inheritDoc} */
	protected function configure() 
	{		
		$form = $this->getForm();
        $form->addGroup($this->getGroupTitle() . $this->getGroupLink());
    }

    abstract protected function getGroupTitle();
    
    abstract protected function getGroupTag();
    
    abstract protected function getGroupAttributes();
    
    protected function getLinkText() {}
    
    protected function getLinkHref() {}
    
    private function getGroupLink()
    {
        $text = $this->getLinkText();
        $href = $this->getLinkHref();
        
        if($href) {
            $href = $this->linkGenerator->link($this->getLinkHref());
            return Html::el("a")
                    ->addAttributes([
                        'href' => $href,
                        'class' => 'btn btn-link pull-right ajax-modal ajax-modal-fixed'
                    ])
                    ->add(Html::el("i")->addClass('material-icons')->addText("add_circle_outline"))
                    ->add($text);
            
//            return '<a href="'.$href.'" class="btn btn-link pull-right"><i class="material-icons"></i>'.$text.'</a>';
        }
    }
    
}