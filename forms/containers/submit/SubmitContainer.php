<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;
use Wame\DynamicObject\Forms\Groups\PublishGroup;

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
        $group = new PublishGroup();
        $group->setTag('div');
        $group->setAttribute('class', 'form-group-transparent');
        
        $this->getForm()->addBaseGroup($group);
        
		$this->addSubmit('submit', _('Submit'))
            ->setAttribute('data-submit', 'form');
    }

}