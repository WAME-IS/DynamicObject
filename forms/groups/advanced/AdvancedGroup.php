<?php

namespace Wame\DynamicObject\Forms\Groups;

use Nette\Utils\Html;
use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface IAdvancedGroupFactory extends IBaseContainer
{
	/** @return AdvancedGroup */
	function create();
}

class AdvancedGroup extends BaseGroup
{
    
    public function getText()
    {
        return _('Advanced');
    }

}