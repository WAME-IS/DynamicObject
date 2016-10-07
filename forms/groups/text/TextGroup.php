<?php

namespace Wame\DynamicObject\Forms\Groups;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface ITextGroupFactory extends IBaseContainer
{
	/** @return TextGroup */
	function create();
}

class TextGroup extends BaseGroup
{
    public function __construct()
    {
        parent::__construct();
        
        $this->addClass('form-group-transparent');
    }
    
    
    /** {@inheritDoc} */
    public function getText()
    {
        return _('Text');
    }
    
}