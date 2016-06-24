<?php

namespace Wame\DynamicObject\Forms;

use Wame\DynamicObject\Forms\BaseFormContainer;


interface ISubmitFormContainerFactory
{
	/** @return SubmitFormContainer */
	function create();
}


class SubmitFormContainer extends BaseFormContainer
{
	/** @var string */
	private $title;
	
	
	public function __construct($title = null) 
	{
		parent::__construct();
		
		if (!$title) {
			$title = _('Save');
		}
		
		$this->title = $title;
	}
	
	
	protected function configure() 
	{		
		$form = $this->getForm();

        $form->addGroup();

		$form->addSubmit('submit', $this->title);
    }

}