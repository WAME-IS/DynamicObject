<?php

namespace Wame\DynamicObject\Traits;

use Wame\DynamicObject\Forms\Groups\BaseGroup;

trait TLink
{
    /**
	 * Create link to custom destination
	 * @param  BaseGroup    $group
	 * @param  string       $href
	 * @param  array        $params
     * 
	 * @return string
	 */
	protected function createLink(BaseGroup $group, $href, $params)
	{
        // TODO: pridat try/catch pre overenie ci je pripojeny k presentru
        $presenter = $group->getParent()->getParent();
        return $presenter->link($href, $params);
	}
    
}
