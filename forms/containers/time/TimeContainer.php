<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface ITimeContainerFactory extends IBaseContainer
{
	/** @return TimeContainer */
	public function create();
}

class TimeContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure() 
	{
		$this->addDateTimePicker('startTime', _('Start time'));
		$this->addDateTimePicker('endTime', _('End time'));
    }

    /** {@inheritDoc} */
	public function setDefaultValues($entity, $langEntity = null)
	{
        $this['startTime']->setDefaultValue($langEntity ? $langEntity->getStartTime() : $entity->getStartTime());
        $this['endTime']->setDefaultValue($langEntity ? $langEntity->getEndTime() : $entity->getEndTime());
	}

    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $entity = $form->getEntity();
        $entity->setStartTime($values['startTime']);
        $entity->setEndTime($values['endTime']);
    }

    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $entity = $form->getEntity();
        $entity->setStartTime($values['startTime']);
        $entity->setEndTime($values['endTime']);
    }

}