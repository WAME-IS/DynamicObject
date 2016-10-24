<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface IValueContainerFactory extends IBaseContainer
{
	/** @return ValueContainer */
	public function create();
}

class ValueContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure() 
	{
		$this->addText('value', _('Value'))
				->setRequired(_('Please enter value'));
    }

    /** {@inheritDoc} */
	public function setDefaultValues($entity, $langEntity = null)
	{
        $this['value']->setDefaultValue($entity->getValue());
	}

    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $entity = method_exists($form, 'getLangEntity') && property_exists($form->getLangEntity(), 'value') ? $form->getLangEntity() : $form->getEntity();
        $entity->setValue($values['value']);
    }

    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $entity = method_exists($form, 'getLangEntity') && property_exists($form->getLangEntity(), 'value') ? $form->getLangEntity() : $form->getEntity();
        $entity->setValue($values['value']);
    }

}