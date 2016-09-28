<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface IDescriptionContainerFactory extends IBaseContainer
{
	/** @return DescriptionContainer */
	public function create();
}

class DescriptionContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure() 
	{
		$this->getForm()->addGroup(_('Short description'));
		
		$this->addTextArea('description', _('Description'));
    }

    /** {@inheritDoc} */
	public function setDefaultValues($entity, $langEntity = null)
	{
		$this['description']->setDefaultValue($entity->getDescription());
	}
    
    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $entity = method_exists($form, 'getLangEntity') ? $form->getLangEntity(): $form->getEntity();
        $entity->setDescription($values['description']);
    }
    
    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $entity = method_exists($form, 'getLangEntity') ? $form->getLangEntity(): $form->getEntity();
        $entity->setDescription($values['description']);
    }

}