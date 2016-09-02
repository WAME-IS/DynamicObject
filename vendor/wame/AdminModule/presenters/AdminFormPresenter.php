<?php

namespace Wame\DynamicObject\Vendor\Wame\AdminModule\Presenters;

class AdminFormPresenter extends \App\AdminModule\Presenters\BasePresenter
{
    public $form;
    
    
    /**
	 * Create parameter
	 * 
	 * @return ParameterForm	form
	 */
	protected function createComponentForm() 
	{
		return $this->form->build();
	}
    
//    protected function addContainers($form, $domain = null)
//    {
//        $i = 0;
//        foreach($this->formRegister->getByDomain($domain) as $container)
//        {
//            $form->addFormContainer($container->create(), $i++);
//        }
//        
//        $this->form = $form;
//    }
    
}
