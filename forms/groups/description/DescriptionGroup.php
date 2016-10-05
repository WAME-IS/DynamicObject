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
    /** {@inheritDoc} */
    public function getText()
    {
        return _('Description');
    }
    
}