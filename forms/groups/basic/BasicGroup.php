<?php

namespace Wame\DynamicObject\Forms\Groups;

use Wame\DynamicObject\Registers\Types\IBaseContainer;
use Wame\DynamicObject\Forms\Groups\BaseGroup;


interface IBasicGroupFactory extends IBaseContainer
{
	/** @return BasicGroup */
	function create();
}


class BasicGroup extends BaseGroup
{
    public function __construct()
    {
        parent::__construct();
        
        $this->setWidth('col-sm-6');
    }
    
    
    /** {@inheritDoc} */
    public function getText()
    {
        return _('Basic');
    }

}