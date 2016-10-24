<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;
use Wame\Utils\Date;

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
        $this['startTime']->setDefaultValue(Date::toString($entity->getStartTime()));
        $this['endTime']->setDefaultValue(Date::toString($entity->getEndTime()));
	}

    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $entity = $form->getEntity();
        $entity->setStartTime(Date::toDateTime($values['startTime']));
        $entity->setEndTime(Date::toDateTime($values['endTime']));
    }

    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $entity = $form->getEntity();
        $entity->setStartTime(Date::toDateTime($values['startTime']));
        $entity->setEndTime(Date::toDateTime($values['endTime']));
    }

}