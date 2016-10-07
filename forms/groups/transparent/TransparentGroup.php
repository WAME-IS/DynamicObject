<?php

namespace Wame\DynamicObject\Forms\Groups;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface ITransparentGroupFactory extends IBaseContainer
{
	/** @return TransparentGroup */
	function create();
}

class TransparentGroup extends BaseGroup
{
    public function __construct()
    {
        parent::__construct();
        
        $this->addClass('form-group-transparent');
    }
    
}