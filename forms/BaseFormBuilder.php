<?php

namespace Wame\DynamicObject\Forms;

use Nette\Application\UI\Form;
use Nette\Forms\IFormRenderer;
use Wame\Core\Registers\PriorityRegister;
use Wame\DynamicObject\Registers\Types\IFormItem;
use Wame\DynamicObject\Renderers\TemplateFormRenderer;

/**
 * Class BaseFormBuilder
 *
 * @package Wame\DynamicObject\Forms
 */
abstract class BaseFormBuilder extends PriorityRegister
{
    /** @var IFormRenderer */
    private $formRenderer;

    /** @var string */
    private $redirect = 'this';


    /**
     * BaseFormBuilder constructor.
     */
    public function __construct()
    {
        parent::__construct(IFormItem::class);
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
     * @param BaseForm $form    form
     * @param array $values     values
     * @throws \Nette\Application\AbortException
     */
	public function formPostSucceeded(BaseForm $form, array $values)
    {
        try {
            $this->postSubmit($form, $values);

            if(!$form->getPresenter()->isAjax()) {
                $form->getPresenter()->redirect($this->redirect);
            }
        } catch (\Exception $e) {
            if ($e instanceof \Nette\Application\AbortException) {
                throw $e;
            }

            $form->addError($e->getMessage());
        }
    }

    /**
     * Redirect to
     *
     * @param $to
     */
    public function redirectTo($to)
    {
        $this->redirect = $to;
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
