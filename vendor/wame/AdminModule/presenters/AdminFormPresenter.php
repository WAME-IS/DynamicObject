<?php

namespace Wame\DynamicObject\Vendor\Wame\AdminModule\Presenters;

use App\AdminModule\Presenters\BasePresenter;
use Wame\DynamicObject\Forms\EntityFormBuilder;

abstract class AdminFormPresenter extends BasePresenter
{
    /** @var EntityFormBuilder */
    public $formBuilder;
    
    /** @var BaseEntity */
    protected $entity;


    public function startup()
    {
        parent::startup();

        $this->formBuilder = $this->context->getService($this->getFormBuilderServiceAlias());
    }


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

    /**
     * Get form builder service alias
     *
     * @return string
     */
	abstract protected function getFormBuilderServiceAlias();
    
}
