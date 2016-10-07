<?php

namespace Wame\DynamicObject\Forms\Groups;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface IDescriptionGroupFactory extends IBaseContainer
{
	/** @return DescriptionGroup */
	function create();
}

class DescriptionGroup extends BaseGroup
{
    public function __construct()
    {
        parent::__construct();
        
        $this->addClass('form-group-transparent');
    }

    /** {@inheritDoc} */
    public function getText()
    {
        return _('Description');
    }
    
}