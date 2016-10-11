<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface IPublishDateContainerFactory extends IBaseContainer
{
	/** @return PublishDateContainer */
	public function create();
}

class PublishDateContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure() 
	{
        $this->addText('publishStartDate', _('Publish start date'))
                ->setType('date');
        
        $this->addText('publishEndDate', _('Publish end date'))
                ->setType('date');
    }

    /** {@inheritDoc} */
	public function setDefaultValues($entity, $langEntity = null)
	{
        $this['publishStartDate']->setDefaultValue($entity->getPublishStartDate());
        $this['publishEndDate']->setDefaultValue($entity->getPublishEndDate());
	}

    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $entity = $form->getEntity();
        $entity->setPublishStartDate($values['publishStartDate']);
        $entity->setPublishEndDate($values['publishEndDate']);
    }

    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $entity = $form->getEntity();
        $entity->setPublishStartDate($values['publishStartDate']);
        $entity->setPublishEndDate($values['publishEndDate']);
    }

}