<?php

namespace Wame\DynamicObject\Forms\Groups;

use Nette\Utils\Html;
use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface IAdvancedGroupFactory extends IBaseContainer
{
	/** @return AdvancedContainer */
	function create();
}

class AdvancedContainer extends BaseGroup
{
    /** @var Html */
    private $tag;
    
    
    /** {@inheritDoc} */
	protected function getGroupTitle()
    {
        return _('Advanced');
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