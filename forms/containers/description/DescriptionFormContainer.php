<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseFormContainerType;

interface IDescriptionFormContainerFactory extends IBaseFormContainerType
{
	/** @return DescriptionFormContainer */
	public function create();
}

class DescriptionFormContainer extends BaseFormContainer
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