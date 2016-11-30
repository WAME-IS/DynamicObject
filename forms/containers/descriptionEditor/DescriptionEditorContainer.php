<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;
use Wame\DynamicObject\Forms\Containers\DescriptionContainer;
use Wame\DynamicObject\Forms\Groups\DescriptionGroup;


interface IDescriptionEditorContainerFactory extends IBaseContainer
{
    /** @return DescriptionEditorContainer */
    public function create();
}


class DescriptionEditorContainer extends DescriptionContainer
{
    /** {@inheritDoc} */
    public function configure()
    {
        $this->getForm()->addBaseGroup(new DescriptionGroup, 'DescriptionGroup');
        $this->addTextArea('description', _('Description'));
    }

}
