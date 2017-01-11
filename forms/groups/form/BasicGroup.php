<?php

namespace Wame\DynamicObject\Forms\Groups;

use Wame\DynamicObject\Registers\Types\IBaseContainer;
use Wame\DynamicObject\Forms\Groups\BaseGroup;


interface IFormGroupFactory extends IBaseContainer
{
    /** @return FormGroup */
    function create();
}


class FormGroup extends BaseGroup
{
    /** {@inheritDoc} */
    public function getText()
    {
        return _('Form');
    }


}
