<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface IIconContainerFactory extends IBaseContainer
{
	/** @return IconContainer */
	public function create();
}

class IconContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure() 
	{
		$this->addText('icon', _('Icon'));
    }

    /** {@inheritDoc} */
	public function setDefaultValues($entity)
	{
		$this['icon']->setDefaultValue($entity->getIcon());
	}

    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $form->getEntity()->setIcon($values['icon']);
    }
    
    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $form->getEntity()->setIcon($values['icon']);
    }

}