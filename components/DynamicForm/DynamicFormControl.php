<?php

namespace Wame\DynamicObject\Components;

use Wame\Core\Components\BaseControl;

interface IDynamicFormControlFactory
{
    /** @return DynamicFormControl */
    public function create();
}

class DynamicFormControl extends BaseControl
{
    /** {@inheritdoc} */
    public function render()
    {
        
    }

}
