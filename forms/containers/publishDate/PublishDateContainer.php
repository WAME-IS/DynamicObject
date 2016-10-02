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
		$this->addDateTimePicker('publishStartDate', _('Publish start date'));
		$this->addDateTimePicker('publishEndDate', _('Publish end date'));
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