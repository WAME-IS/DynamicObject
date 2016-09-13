<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface ISubmitContainerFactory extends IBaseContainer
{
	/** @return SubmitContainer */
	public function create();
}

class SubmitContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure() 
	{
		$this->addSubmit('submit', _('Submit'));
    }

}