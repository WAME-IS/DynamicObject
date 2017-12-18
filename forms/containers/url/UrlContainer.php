<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;


interface IUrlContainerFactory extends IBaseContainer
{
	/** @return UrlContainer */
	public function create();
}


class UrlContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure() 
	{
		$this->addText('url', _('Url'));
    }


    /** {@inheritDoc} */
	public function setDefaultValues($entity)
	{
        $this['url']->setDefaultValue($entity->getUrl());
	}


    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $form->getEntity()->setUrl($values['url']);
    }


    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $form->getEntity()->setUrl($values['url']);
    }

}
