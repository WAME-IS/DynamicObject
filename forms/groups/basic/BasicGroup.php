<?php

namespace Wame\DynamicObject\Forms\Groups;

use Wame\DynamicObject\Registers\Types\IBaseContainer;
use Wame\DynamicObject\Forms\Groups\BaseGroup;
use Nette\Utils\Html;

interface IBasicGroupFactory extends IBaseContainer
{
	/** @return BasicContainer */
	function create();
}

class BasicContainer extends BaseGroup
{
    /** @var Html */
    private $tag;
    
    
    /** {@inheritDoc} */
	protected function getGroupTitle()
    {
        return _('Basic');
    }

    protected function getGroupAttributes() {
        return [];
    }

    protected function getGroupTag()
    {
        if(!$this->tag) {
            $this->tag = Html::el('div')->setAttibutes($this->getGroupAttributes());
        }
        
        return $this->tag;
    }

}