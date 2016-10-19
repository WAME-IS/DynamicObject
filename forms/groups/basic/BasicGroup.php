<?php

namespace Wame\DynamicObject\Forms\Groups;

use Wame\DynamicObject\Registers\Types\IBaseContainer;
use Wame\DynamicObject\Forms\Groups\BaseGroup;


interface IBasicGroupFactory extends IBaseContainer
{
    /** @return BasicGroup */
    function create();
}


class BasicGroup extends BaseGroup
{
    /** {@inheritDoc} */
    public function getText()
    {
        return _('Basic');
    }


}
