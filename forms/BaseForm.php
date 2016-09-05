<?php

namespace Wame\DynamicObject\Forms;

use Nette\Application\UI\Form;
use Wame\Core\Registers\PriorityRegister;
use Wame\DynamicObject\Registers\Types\IBaseFormContainerType;

abstract class BaseForm extends PriorityRegister
{
	const ACTION_CREATE = 'create';
	const ACTION_EDIT = 'edit';
    
    
    public function __construct()
    {
        parent::__construct(IBaseFormContainerType::class);
    }
    
    
    /**
     * Build
     * 
     * @param string $domain    domain
     * @return Form
     */
	public function build($domain = null)
	{
		$form = $this->createForm($domain);
        
        if($this->getSubmitText()) {
            $form->addSubmit('submit', $this->getSubmitText());
        }
        
        $form->onSuccess[] = [$this, 'formSucceeded'];
        
		return $form;
	}
	
    /**
     * Form succeeded
     * 
     * @param Form $form    form
     * @param array $values values
     * @throws \Exception
     */
	public function formSucceeded(Form $form, $values)
	{
		$presenter = $form->getPresenter();

		try {
			$this->submit($form, $values);
            
			$presenter->redirect('this');
		} catch (\Exception $e) {
			if ($e instanceof \Nette\Application\AbortException) {
				throw $e;
			}
			
			$form->addError($e->getMessage());
		}
	}
    
    
    /**
	 * Create Form
	 * 
	 * @return Form
	 */
	private function createForm($domain)
	{
		$form = new Form;
		
		$form->setRenderer(new \Tomaj\Form\Renderer\BootstrapVerticalRenderer);
		$this->attachFormContainers($form, $domain);
		
		return $form;
	}
    
    /**
     * Attach form containers
     * 
     * @param Form $form        form
     * @param string $domain    domain
     */
    private function attachFormContainers(Form $form, $domain = null)
    {
        foreach($this->getByDomain($domain) as $name => $containerFactory)
        {
            $container = $containerFactory->create();
            
            $form->addComponent($container, $name); // TODO: default nazov
            
            if (method_exists($container, 'setDefaultValues')) {
				$container->setDefaultValues($this);
			}
        }
    }
	
    /**
     * Submit
     * 
     * @param Form $form        form
     * @param array $values     values
     */
    public function submit($form, $values)
    {
        
    }
    
    
    /**
     * Is edit mode
     * 
     * @return true if edit mode, otherwise false
     */
    protected function isEditMode()
    {
        return $this->parameters['action'] == self::ACTION_EDIT;
    }
    
    /**
     * Get submit text
     * 
     * @return string
     */
    protected function getSubmitText()
    {
//        return _('Submit');
    }
    
}
