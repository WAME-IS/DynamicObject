<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface IParameterHeightContainerFactory extends IBaseContainer
{
	/** @return ParameterHeightContainer */
	public function create();
}

class ParameterHeightContainer extends BaseContainer
{
    const INPUT_HEIGHT = 'height';
    
    
    /** {@inheritDoc} */
    public function configure() 
	{
		$this->addText(self::INPUT_HEIGHT, _('Height'));
    }

    /** {@inheritDoc} */
	public function setDefaultValues($entity)
	{
        $this[self::INPUT_HEIGHT]->setDefaultValue($entity->getParameter(self::INPUT_HEIGHT));
	}

    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $form->getEntity()->setParameter(self::INPUT_HEIGHT, $values[self::INPUT_HEIGHT]);
    }

    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $form->getEntity()->setParameter(self::INPUT_HEIGHT, $values[self::INPUT_HEIGHT]);
    }

}