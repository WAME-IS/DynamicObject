<?php

namespace Wame\DynamicObject\Forms\Groups;

use Wame\DynamicObject\Forms\Containers\BaseContainer;

abstract class BaseGroup extends BaseContainer
{
    /** {@inheritDoc} */
	protected function configure() 
	{		
		$form = $this->getForm();
        $form->addGroup($this->getGroupTitle());
    }

    abstract protected function getGroupTitle();
    
    abstract protected function getGroupTag();
    
    abstract protected function getGroupAttributes();
    
}