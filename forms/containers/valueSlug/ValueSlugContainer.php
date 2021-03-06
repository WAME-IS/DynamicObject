<?php

namespace Wame\DynamicObject\Forms\Containers;

use Nette\Utils\Strings;
use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface IValueSlugContainerFactory extends IBaseContainer
{
	/** @return ValueSlugContainer */
	public function create();
}

class ValueSlugContainer extends BaseContainer
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
        $entity->setSlug($values['slug']?:(Strings::webalize($form->values['ValueContainer']['value'])));
    }

    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $entity = method_exists($form, 'getLangEntity') ? $form->getLangEntity(): $form->getEntity();
        $entity->setSlug($values['slug']?:(Strings::webalize($form->values['ValueContainer']['value'])));
    }

}