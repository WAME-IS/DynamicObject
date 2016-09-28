<?php

namespace Wame\DynamicObject\Vendor\Wame\AdminModule\Presenters;

use Wame\DynamicObject\Forms\BaseFormBuilder;

class AdminFormPresenter extends \App\AdminModule\Presenters\BasePresenter
{
    /** @var BaseFormBuilder */
    public $formBuilder;
    
    /** @var BaseEntity */
    protected $entity;
    
    
    /**
	 * Create component form
	 * 
	 * @return BaseForm	form
	 */
	protected function createComponentForm() 
	{
		return $this->formBuilder
//                ->setFormRenderer(new \Wame\Core\Models\MaterialDesignRenderer)
                ->setEntity($this->entity)
                ->build($this->id);
	}
    
}
