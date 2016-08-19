<?php

namespace Wame\DynamicObject\Vendor\Wame\AdminModule\Presenters;

use Wame\DynamicObject\Vendor\Wame\AdminModule\Registers\AdminFormRegister;
use Wame\Core\Forms\FormFactory;

class AdminFormPresenter extends \App\AdminModule\Presenters\BasePresenter
{
    /** @var BaseRegister */
    protected $formRegister;
    
    /** @var AdminFormRegister @inject */
    public $adminFormRegister;
    
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
    
    protected function addContainers($form, $domain = null)
    {
        $i = 0;
        foreach($this->formRegister->getByDomain($domain) as $container)
        {
            $form->addFormContainer($container->create(), $i++);
        }
        
        $this->form = $form;
    }
    
}
