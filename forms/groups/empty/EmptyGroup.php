<?php

namespace Wame\DynamicObject\Forms\Groups;

use Wame\DynamicObject\Registers\Types\IBaseContainer;
use Wame\DynamicObject\Forms\Groups\BaseGroup;


interface IEmptyGroupFactory extends IBaseContainer
{
    /** @return EmptyGroup */
    function create();
}


class EmptyGroup extends BaseGroup
{
    public function __construct()
    {
        parent::__construct();

        $this->addClass('form-group-empty');
    }
}
