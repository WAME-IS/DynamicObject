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
	public function setDefaultValues($entity, $langEntity)
	{
		$this['description']->setDefaultValue($langEntity->getDescription());
	}
    
    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $form->getLangEntity()->setDescription($values['description']);
    }
    
    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $form->getLangEntity()->setDescription($values['description']);
    }

}