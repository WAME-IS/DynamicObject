<?php

namespace Wame\DynamicObject\Traits;

use Wame\DynamicObject\Forms\Tabs\BaseTab;

trait TCurrentTab
{
    /** @var BaseTab */
    protected $currentTab;
    
    
    /**
     * Set current tab
     * 
     * @return self
     */
    public function setCurrentTab(BaseTab $tab = NULL)
    {
        $this->currentTab = $tab;
        
        return $this;
    }
    
    /**
     * Returns current tab
     * 
     * @return BaseTab
     */
    public function getCurrentTab()
    {
        return $this->currentTab;
    }
    
}
