<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface ISaveContainerFactory extends IBaseContainer
{
	/** @return SaveContainer */
	public function create();
}

class SaveContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure() 
	{
		$this->addSubmit('save', _('Save'));
    }

}