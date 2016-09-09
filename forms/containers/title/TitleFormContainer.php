<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseFormContainerType;

interface ITitleFormContainerFactory extends IBaseFormContainerType
{
	/** @return TitleFormContainer */
	public function create();
}

class TitleFormContainer extends BaseFormContainer
{
    /** {@inheritDoc} */
    public function configure() 
	{
		$this->addText('title', _('Title'))
				->setRequired(_('Please enter title'));
    }

    /** {@inheritDoc} */
	public function setDefaultValues($entity, $langEntity)
	{
		$this['title']->setDefaultValue($langEntity->getTitle());
	}

    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $form->getLangEntity()->setTitle($values['title']);
    }

    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $form->getLangEntity()->setTitle($values['title']);
    }

}