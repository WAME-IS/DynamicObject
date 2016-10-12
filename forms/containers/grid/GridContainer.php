<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Forms\Containers\BaseContainer;
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
        
        $this->monitor(\Nette\Application\UI\Presenter::class);
    }
    
    
    /** {@inheritDoc} */
    public function configure() 
	{
        
    }
    
    
    /** {@inheritDoc} */
    protected function attached($object)
    {
        parent::attached($object);
        
        if($object instanceof \Nette\Application\UI\Presenter) {
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
     * @param type $presenter
     * @return QueryBuilder
     */
    abstract protected function getDataSource($presenter);
    
    
    /**
     * Add grid
     * 
     * @param Presenter $presenter
     */
    private function addGrid($presenter)
    {
        $gridName = $this->getGridName();
        
        $grid = $presenter->context->getService($gridName);
        $grid->setDataSource($this->getDataSource($presenter));
        $grid->setTemplateFile(TEMPLATES_PATH . '/materialDesign/ublaboo/datagrid/src/templates/datagrid_nofilter.latte');
        
        $this->addComponent($grid, 'grid');
    }
    
}