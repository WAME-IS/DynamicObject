<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;
use Wame\DynamicObject\Forms\Containers\DescriptionContainer;

interface IDescriptionEditorContainerFactory extends IBaseContainer
{
    /** @return DescriptionEditorContainer */
    public function create();
}

class DescriptionEditorContainer extends DescriptionContainer
{
    
}
