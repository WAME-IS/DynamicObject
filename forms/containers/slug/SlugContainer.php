<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface ISlugContainerFactory extends IBaseContainer
{
	/** @return SlugContainer */
	public function create();
}

class SlugContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure() 
	{
		$this->addText('slug', _('Slug'));
    }

    /** {@inheritDoc} */
	public function setDefaultValues($entity, $langEntity = null)
	{
        $this['slug']->setDefaultValue($langEntity ? $langEntity->getSlug() : $entity->getSlug());
	}

    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $entity = method_exists($form, 'getLangEntity') ? $form->getLangEntity(): $form->getEntity();
        $entity->setSlug($values['slug']?:(Strings::webalize($values['title'])));
    }

    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $entity = method_exists($form, 'getLangEntity') ? $form->getLangEntity(): $form->getEntity();
        $entity->setSlug($values['slug']?:(Strings::webalize($values['title'])));
    }

}