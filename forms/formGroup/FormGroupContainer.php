<?php

namespace Wame\DynamicObject\Forms;

use Wame\DynamicObject\Forms\BaseFormContainer;

interface IFormGroupContainerFactory
{
	/** @return FormGroupContainer */
	function create();
}


class FormGroupContainer extends BaseFormContainer
{
	/** @var string */
	private $title;
	
	
	public function __construct($title = null) 
	{
		parent::__construct();
		
		$this->title = $title;
	}
	
	
	protected function configure() 
	{		
		$form = $this->getForm();

        $form->addGroup($this->title);
    }

	
	public function render() {
		
	}

}