<?php

namespace Wame\DynamicObject\Vendor\Wame\AdminModule\Registers;

use Wame\DynamicObject\Registers\BaseFormRegister;
use Wame\DynamicObject\Vendor\Wame\AdminModule\Registers\IAdminFormType;

class AdminFormRegister extends BaseFormRegister
{
    public function __construct()
    {
        parent::__construct(IAdminFormType::class);
    }
    
}
