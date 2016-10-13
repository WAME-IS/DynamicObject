<?php

namespace Wame\DynamicObject\Forms\Containers;

use App\Core\Presenters\BasePresenter;
use Doctrine\ORM\QueryBuilder;
use Wame\DataGridControl\DataGridControl;
use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface IGridContainerFactory extends IBaseContainer
{
	/** @return GridContainer */
	public function create();
}

abstract class GridContainer extends BaseContainer
{
    public function __construct()
    {
        parent::__construct();
        
        $this->monitor(BasePresenter::class);
    }
    
    
    /** {@inheritDoc} */
    public function configure() 
	{
        
    }
    
    
    /** {@inheritDoc} */
    protected function attached($object)
    {
        parent::attached($object);
        
        if($object instanceof BasePresenter) {
            $this->addGrid($object);
        }
    }
    
    
    /**
     * Get grid name
     * 
     * @return string
     */
    abstract protected function getGridName();
    
    /**
     * Get data source
     * 
     * @param BasePresenter $presenter  presenter
     * @return QueryBuilder
     */
    abstract protected function getDataSource(BasePresenter $presenter);
    
    
    /**
     * Add grid
     * 
     * @param BasePresenter $presenter  presenter
     */
    private function addGrid(BasePresenter $presenter)
    {
        $gridName = $this->getGridName();

        /** @var DataGridControl $grid */
        $grid = $presenter->context->getService($gridName);
        $grid->setDataSource($this->getDataSource($presenter));
        $grid->setTemplateFile(TEMPLATES_PATH . '/materialDesign/ublaboo/datagrid/src/templates/datagrid_nofilter.latte');
        
        $this->addComponent($grid, 'grid');
    }
    
}