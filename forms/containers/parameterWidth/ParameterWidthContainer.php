<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface IParameterWidthContainerFactory extends IBaseContainer
{
	/** @return ParameterWidthContainer */
	public function create();
}

class ParameterWidthContainer extends BaseContainer
{
    const INPUT_WIDTH = 'width';
    
    
    /** {@inheritDoc} */
    public function configure() 
	{
		$this->addText(self::INPUT_WIDTH, _('Width'));
    }

    /** {@inheritDoc} */
	public function setDefaultValues($entity)
	{
        $this[self::INPUT_WIDTH]->setDefaultValue($entity->getParameter(self::INPUT_WIDTH));
	}

    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $form->getEntity()->setParameter(self::INPUT_WIDTH, $values[self::INPUT_WIDTH]);
    }

    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $form->getEntity()->setParameter(self::INPUT_WIDTH, $values[self::INPUT_WIDTH]);
    }

}