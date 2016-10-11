<?php

namespace Wame\DynamicObject\Forms\Tabs;

use Wame\DynamicObject\Registers\Types\IFormItem;
use Wame\DynamicObject\Forms\Tabs\BaseTab;

interface INoTabFactory extends IFormItem
{
	/** @return NoTab */
	function create();
}

class NoTab extends BaseTab
{

}