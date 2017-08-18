<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Forms\Containers\BaseContainer;
use Wame\DynamicObject\Registers\Types\IBaseContainer;


interface ITemplateContainerFactory extends IBaseContainer
{
	/** @return TemplateContainer */
	public function create();
}


class TemplateContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure()
	{
        $this->addText('template', _('Template'))
                ->setAttribute('placeholder', 'default.latte');
    }


    /** {@inheritDoc} */
    public function setDefaultValues($entity)
    {
        $this['template']->setDefaultValue($entity->getTemplate());
    }


    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $form->getEntity()->setTemplate($values['template']);
    }


    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $form->getEntity()->setTemplate($values['template']);
    }

}
