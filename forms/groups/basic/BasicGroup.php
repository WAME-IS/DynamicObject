<?php

namespace Wame\DynamicObject\Forms\Groups;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

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
