<?php

namespace Wame\DynamicObject\Forms\Groups;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface IAdvancedGroupFactory extends IBaseContainer
{
	/** @return AdvancedGroup */
	function create();
}

class AdvancedGroup extends BaseGroup
{
    /** {@inheritDoc} */
    public function getText()
    {
        return _('Advanced');
    }

}