<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;
use Wame\DynamicObject\Forms\Groups\TextGroup;

interface ITextContainerFactory extends IBaseContainer
{
	/** @return TextContainer */
	public function create();
}

class TextContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure() 
	{
	    dump($this);
        $this->getForm()->addBaseGroup(new TextGroup, 'TextGroup');
        
		$this->addTextArea('text', _('Text'));
    }

    /** {@inheritDoc} */
	public function setDefaultValues($entity, $langEntity = null)
	{
		$this['text']->setDefaultValue($entity->getText());
	}
    
    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $entity = method_exists($form, 'getLangEntity') ? $form->getLangEntity(): $form->getEntity();
        $entity->setText($values['text']);
    }
    
    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $entity = method_exists($form, 'getLangEntity') ? $form->getLangEntity(): $form->getEntity();
        $entity->setText($values['text']);
    }

}