<?php

namespace Wame\DynamicObject\Forms;

use Nette\Application\UI\Form;
use Wame\Core\Registers\PriorityRegister;
use Wame\DynamicObject\Registers\Types\IBaseContainer;

abstract class BaseFormBuilder extends PriorityRegister
{
    public function __construct()
    {
        parent::__construct(IBaseContainer::class);
    }
    
    
    /**
     * Build
     * 
     * @param string $domain    domain
     * @return Form
     */
	public function build($domain = null)
	{
        $form = $this->createForm();
		
//		$form->setRenderer($this->getFormRenderer());
		$this->attachFormContainers($form, $domain);
        
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
     * Submit
     * 
     * @param Form $form        form
     * @param array $values     values
     */
    public function submit($form, $values) {}
    
    
    /**
     * Get submit text
     * 
     * @return string
     */
    protected function getSubmitText() {}
    
    /**
     * Get form renderer
     * 
     * @return \Tomaj\Form\Renderer\BootstrapVerticalRenderer
     */
    protected function getFormRenderer()
    {
        return new \Tomaj\Form\Renderer\BootstrapVerticalRenderer;
//        return new \Wame\DynamicObject\Renderers\TemplateFormRenderer;
    }
    
    /**
	 * Create Form
	 * 
	 * @return Form
	 */
	protected function createForm()
	{
		$form = new BaseForm;
		
		return $form;
	}
    
    /**
     * Attach form containers
     * 
     * @param Form $form        form
     * @param string $domain    domain
     */
    protected function attachFormContainers($form, $domain = null)
    {
//        foreach($this->getByDomain($domain) as $name => $containerFactory) {
//            $container = $containerFactory->create();
//            \Tracy\Debugger::barDump($containerFactory);
//            $form->addComponent($container, $name); // TODO: default nazov
//            $this->setDefaultValue($form, $container);
//        }
        
        foreach($this->array as $item) {
            $containerFactory = $item['service'];
            $containerName = $item['name'];
            $container = $containerFactory->create();
            $form->addComponent($container, $containerName);
            $this->setDefaultValue($form, $container);
        }
    }
    
    /**
     * Set default value
     * 
     * @param Form $form            form
     * @param Container $container  container
     */
    protected function setDefaultValue($form, $container)
    {
        
    }
    
}
