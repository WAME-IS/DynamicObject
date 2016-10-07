<?php

namespace Wame\DynamicObject\Vendor\Wame\AdminModule\Presenters;

use App\AdminModule\Presenters\BasePresenter;

abstract class AdminFormPresenter extends BasePresenter
{
    /** @var BaseRepository */
    public $repository;
    
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
     * Create component grid
     * 
     * @return DataGridControl
     */
    protected function createComponentGrid()
    {
        if(!$this->repository && $this->getGridServiceAlias()) return;
        
        $grid = $this->context->getService($this->getGridServiceAlias());
        
        $qb = $this->repository->createQueryBuilder();
		$grid->setDataSource($qb);
        
        return $grid;
    }

    /**
     * Get form builder service alias
     *
     * @return string
     */
	abstract protected function getFormBuilderServiceAlias();
    
}
