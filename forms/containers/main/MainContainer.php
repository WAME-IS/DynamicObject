<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface IMainContainerFactory extends IBaseContainer
{
	/** @return MainContainer */
	public function create();
}

class MainContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure() 
	{
		$this->addCheckbox('main', _('Main'));
    }

    /** {@inheritDoc} */
	public function setDefaultValues($entity)
	{
        $this['main']->setDefaultValue($entity->getMain());
	}

    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $form->getEntity()->setMain($values['main']);
    }

    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $form->getEntity()->setMain($values['main']);
    }

}