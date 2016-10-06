<?php

namespace Wame\DynamicObject\Forms\Tabs;

use Wame\DynamicObject\Registers\Types\IFormItem;
use Wame\DynamicObject\Forms\Tabs\BaseTab;

interface IGeneralTabFactory extends IFormItem
{
	/** @return GeneralTab */
	function create();
}

class GeneralTab extends BaseTab
{
    /** {@inheritDoc} */
    public function getText()
    {
        return _('General');
    }

}