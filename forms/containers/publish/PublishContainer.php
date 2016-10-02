<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\Core\Repositories\BaseRepository;
use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface IPublishContainerFactory extends IBaseContainer
{
	/** @return PublishContainer */
	public function create();
}

class PublishContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure() 
	{
		$this->addSubmit('publish', _('Save & Publish'));
    }

    /** {@inheritdoc} */
    public function create($form, $values)
    {
        if($this['publish']->isSubmittedBy()) {
            $form->getEntity()->setStatus(BaseRepository::STATUS_ENABLED);
        }
    }

}