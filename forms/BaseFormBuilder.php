<?php

namespace Wame\DynamicObject\Forms;

use Nette\Application\UI\Form;
use Tracy\Debugger;
use Wame\Core\Registers\PriorityRegister;
use Wame\DynamicObject\Registers\Types\IBaseContainer;
use Nette\Forms\IFormRenderer;
use Wame\DynamicObject\Renderers\TemplateFormRenderer;

abstract class BaseFormBuilder extends PriorityRegister
{
    /** @var IFormRenderer */
    private $formRenderer;
    
    
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
		
		$form->setRenderer($this->getFormRenderer());
		$this->attachFormContainers($form, $domain);
        
//        if($this->getSubmitText()) {
//            $form->addSubmit('submit', $this->getSubmitText());
//        }
        
        $form->onSuccess[] = [$this, 'formSucceeded'];
        $form->onPostSuccess[] = [$this, 'formPostSucceeded'];

		return $form;
	}
	
    /**
     * Form succeeded
     * 
     * @param Form $form    form
     * @param array $values values
     * @throws \Exception
     */
	public function formSucceeded(Form $form, array $values)
	{
		try {
			$this->submit($form, $values);
            
//			$form->getPresenter()->redirect('this');
		} catch (\Exception $e) {
			if ($e instanceof \Nette\Application\AbortException) {
				throw $e;
			}
			
			$form->addError($e->getMessage());
		}
	}

    /**
     * Form post succeeded
     *
     * @param BaseForm $form form
     * @param array $values values
     * @throws \Nette\Application\AbortException
     */
	public function formPostSucceeded(BaseForm $form, array $values)
    {
        try {
            $this->postSubmit($form, $values);

//			$form->getPresenter()->redirect('this');
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
     * @param BaseForm $form    form
     * @param array $values     values
     */
    public function submit(BaseForm $form, array $values) {}

    /**
     * Post submit
     *
     * @param BaseForm $form    form
     * @param array $values     values
     */
    public function postSubmit(BaseForm $form, array $values) {}
    
    /**
     * Set renderer
     * 
     * @param IFormRenderer $formRenderer   form renderer
     * @return $this
     */
    public function setFormRenderer(IFormRenderer $formRenderer)
    {
        $this->formRenderer($formRenderer);
        
        return $this;
    }
    
    
    /**
     * Get submit text
     * 
     * @return string
     */
    protected function getSubmitText() {}
    
    /**
     * Get form renderer
     * 
     * @return IFormRenderer
     */
    protected function getFormRenderer()
    {
        if($this->formRenderer) {
            return $this->formRenderer;
        } else {
            return new TemplateFormRenderer;
        }
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
        foreach($this->array as $item) {
            if($item['parameters']['domain'] == null || $item['parameters']['domain'] == $domain) {
                $containerFactory = $item['service'];
                $containerName = $item['name'];
                $container = $containerFactory->create();

                $form->addComponent($container, $containerName);
                $this->setDefaultValue($form, $container);
            }
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
