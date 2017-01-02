<?php

namespace Wame\DynamicObject\Vendor\Wame\AdminModule\Forms\Containers;

use Nette\DI;
use Tracy\Debugger;
use Wame\DynamicObject\Forms\Containers\BaseContainer;
use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface IContainerContainerFactory extends IBaseContainer
{
    /** @return ContainerContainer */
    public function create();
}

class ContainerContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure()
    {
        $containers = $this->container->findByType(IBaseContainer::class);

//        $items = [];
//
//        foreach($containers as $container) {
//            $items[] = $container->
//        }

        $this->addCheckboxList('containers', _('Containers'), $containers);
    }

    /** {@inheritDoc} */
    public function setDefaultValues($entity, $langEntity = null)
    {
//        $this['containers']->setDefaultValue($entity->getParameter('containers'));
    }

    /** {@inheritDoc} */
    public function create($form, $values)
    {
//        $form->getEntity()->setParameter('custom', $values['custom']);
    }

    /** {@inheritDoc} */
    public function update($form, $values)
    {
//        $form->getEntity()->setParameter('custom', $values['custom']);
    }

}