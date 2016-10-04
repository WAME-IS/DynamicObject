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
    
}