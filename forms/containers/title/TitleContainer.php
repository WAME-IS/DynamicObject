<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface ITitleContainerFactory extends IBaseContainer
{
	/** @return TitleContainer */
	public function create();
}

class TitleContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure() 
	{
		$this->addText('title', _('Title'))
				->setRequired(_('Please enter title'));
    }

    /** {@inheritDoc} */
	public function setDefaultValues($entity, $langEntity = null)
	{
        $this['title']->setDefaultValue($entity->getTitle());
	}

    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $entity = method_exists($form, 'getLangEntity') && property_exists($form->getLangEntity(), 'title') ? $form->getLangEntity() : $form->getEntity();
        $entity->setTitle($values['title']);
    }

    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $entity = method_exists($form, 'getLangEntity') && property_exists($form->getLangEntity(), 'title') ? $form->getLangEntity() : $form->getEntity();
        $entity->setTitle($values['title']);
    }

}