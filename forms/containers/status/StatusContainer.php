<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;
use Wame\Core\Repositories\BaseRepository;

interface IStatusContainerFactory extends IBaseContainer
{
	/** @return StatusContainer */
	public function create();
}

class StatusContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure() 
	{
        $statsList = $this->getParent()->getRepository()->getStatusList();
        
		$this->addRadioList('status', _('Status'), $statsList)
            ->setRequired()
            ->setDefaultValue(BaseRepository::STATUS_ENABLED);
    }

    /** {@inheritDoc} */
	public function setDefaultValues($entity, $langEntity = null)
	{
        $this['status']->setDefaultValue($entity->getStatus());
	}

    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $form->getEntity()->setStatus($values['status']);
    }

    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $form->getEntity()->setStatus($values['status']);
    }

}