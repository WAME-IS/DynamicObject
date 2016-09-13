<?php

namespace Wame\DynamicObject\Registers;

use Wame\Core\Registers\PriorityRegister;
use Wame\DynamicObject\Registers\Types\IBaseContainer;

class BaseFormRegister extends PriorityRegister
{
    public function __construct()
    {
        parent::__construct(IBaseContainer::class);
    }
    
}
