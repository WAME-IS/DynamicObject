<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;


interface IShowDescriptionContainerFactory extends IBaseContainer
{
    /** @return ShowDescriptionContainer */
    public function create();
}


class ShowDescriptionContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure()
    {
        $this->addCheckbox('showDescription', _('Show description'));
    }


    /** {@inheritDoc} */
    public function setDefaultValues($entity, $langEntity = null)
    {
        $this['showDescription']->setDefaultValue($entity->getParameter('showDescription'));
    }


    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $parameters = $form->getEntity()->getParamters();

        $form->getEntity()->setParameters(array_merge($parameters, ['showDescription' => $values['showDescription']]));
    }


    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $parameters = $form->getEntity()->getParamters();

        $form->getEntity()->setParameters(array_merge($parameters, ['showDescription' => $values['showDescription']]));
    }


}
