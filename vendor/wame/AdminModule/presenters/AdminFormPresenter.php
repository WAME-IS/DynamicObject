<?php

namespace Wame\DynamicObject\Vendor\Wame\AdminModule\Presenters;

use Wame\DynamicObject\Forms\BaseFormBuilder;

class AdminFormPresenter extends \App\AdminModule\Presenters\BasePresenter
{
    /** @var BaseFormBuilder */
    public $formBuilder;
    
    
    /**
	 * Create parameter
	 * 
	 * @return ParameterForm	form
	 */
	protected function createComponentForm() 
	{
		return $this->formBuilder->build($this->id);
	}
    
}
