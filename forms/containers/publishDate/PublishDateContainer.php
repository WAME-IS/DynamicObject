<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;
use Wame\Utils\Date;

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
        $this->addText('publishStartDate', _('Publish start date'));

        $this->addText('publishEndDate', _('Publish end date'));
    }

    /** {@inheritDoc} */
	public function setDefaultValues($entity, $langEntity = null)
	{
        $this['publishStartDate']->setDefaultValue(Date::toString($entity->getPublishStartDate(), 'd.m.Y H:i'));
        $this['publishEndDate']->setDefaultValue(Date::toString($entity->getPublishEndDate(), 'd.m.Y H:i'));
	}

    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $entity = $form->getEntity();

        if($values['publishStartDate']) {
            $entity->setPublishStartDate(Date::toDateTime($values['publishStartDate']));
        }

        if($values['publishEndDate']) {
            $entity->setPublishEndDate(Date::toDateTime($values['publishEndDate']));
        }
    }

    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $entity = $form->getEntity();

        $entity->setPublishStartDate(Date::toDateTime($values['publishStartDate']));
        $entity->setPublishEndDate(Date::toDateTime($values['publishEndDate']));
    }

}