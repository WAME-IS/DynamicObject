<?php

namespace Wame\DynamicObject\Forms\Groups;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface IPublishGroupFactory extends IBaseContainer
{
	/** @return PublishGroup */
	function create();
}

class PublishGroup extends BaseGroup
{
    public function __construct()
    {
        parent::__construct();
        
        $this->setWidth('col-sm-6');
    }
    
    
    /** {@inheritDoc} */
    public function getText()
    {
        return _('Publish');
    }
    
}