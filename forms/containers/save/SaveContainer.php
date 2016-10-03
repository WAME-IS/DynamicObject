<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\Core\Repositories\BaseRepository;
use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface ISaveContainerFactory extends IBaseContainer
{
	/** @return SaveContainer */
	public function create();
}

class SaveContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure() 
	{
		$this->addSubmit('save', _('Save'))
            ->setAttribute('data-submit', 'form');
    }

    /** {@inheritdoc} */
    public function create($form, $values)
    {
        if($this['save']->isSubmittedBy()) {
            $form->getEntity()->setStatus(BaseRepository::STATUS_DISABLED);
        }
    }

}