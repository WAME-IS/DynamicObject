<?php

namespace Wame\DynamicObject\Forms\Tabs;

use Wame\DynamicObject\Registers\Types\IFormItem;
use Wame\DynamicObject\Forms\Tabs\BaseTab;

interface IAdvancedTabFactory extends IFormItem
{
	/** @return AdvancedTab */
	function create();
}

class AdvancedTab extends BaseTab
{
    /** {@inheritDoc} */
    public function getText()
    {
        return _('Advanced');
    }

}