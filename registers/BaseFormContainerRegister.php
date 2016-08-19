<?php

namespace Wame\DynamicObject\Registers;

use Wame\Core\Registers\PriorityRegister;
use Wame\DynamicObject\Registers\Types\IBaseFormContainerType;

abstract class BaseFormContainerRegister extends PriorityRegister
{
    public function __construct()
    {
        parent::__construct(IBaseFormContainerType::class);
    }
}
