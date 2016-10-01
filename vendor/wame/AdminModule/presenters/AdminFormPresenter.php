<?php

namespace Wame\DynamicObject\Vendor\Wame\AdminModule\Presenters;

use App\AdminModule\Presenters\BasePresenter;

abstract class AdminFormPresenter extends BasePresenter
{
    /** @var BaseEntity */
    protected $entity;


    /**
	 * Create component form
	 * 
	 * @return BaseForm	form
	 */
	protected function createComponentForm() 
	{
		return $this->context->getService($this->getFormBuilderServiceAlias())
//                ->setFormRenderer(new \Wame\Core\Models\MaterialDesignRenderer)
                ->setEntity($this->entity)
                ->build($this->id);
	}

    /**
     * Get form builder service alias
     *
     * @return string
     */
	abstract protected function getFormBuilderServiceAlias();
    
}
