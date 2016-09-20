<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface INameContainerFactory extends IBaseContainer
{
	/** @return NameContainer */
	public function create();
}

class NameContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure() 
	{
		$this->addText('name', _('Name'))
				->setRequired(_('Please enter name'));
    }

    /** {@inheritDoc} */
	public function setDefaultValues($entity)
	{
        $this['name']->setDefaultValue($entity->getName());
	}

    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $form->getEntity()->setName($values['name']);
    }

    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $form->getEntity()->setName($values['name']);
    }

}