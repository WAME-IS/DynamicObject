<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;


interface IShowTitleContainerFactory extends IBaseContainer
{
    /** @return ShowTitleContainer */
    public function create();
}


class ShowTitleContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure()
    {
        $this->addCheckbox('showTitle', _('Show title'));
    }


    /** {@inheritDoc} */
    public function setDefaultValues($entity, $langEntity = null)
    {
        $this['showTitle']->setDefaultValue($entity->getParameter('showTitle'));
    }


    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $parameters = $form->getEntity()->getParameters();

        $form->getEntity()->setParameters(array_merge($parameters, ['showTitle' => $values['showTitle']]));
    }


    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $parameters = $form->getEntity()->getParameters();

        $form->getEntity()->setParameters(array_merge($parameters, ['showTitle' => $values['showTitle']]));
    }


}
