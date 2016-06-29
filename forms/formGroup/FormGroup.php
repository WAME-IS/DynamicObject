<?php

namespace Wame\DynamicObject\Forms;


trait FormGroup
{
	/**
	 * Return form group
	 * 
	 * @param string $formName
	 * @param string $groupName
	 */
	public function getFormGroup($formName, $groupName)
	{
		return $this->getComponent('form')->getComponent($formName)->getComponent($formName)->getGroup($groupName);
	}

}