<?php

namespace Wame\DynamicObject\Forms;

use Nette\Application\UI\Form;
use Nette\Forms\IFormRenderer;
use Wame\Core\Registers\PriorityRegister;
use Wame\DynamicObject\Forms\Containers\BaseContainer;
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

    /** @var array */
    private $redirectParameters = [];

    /** @var bool */
    protected $ajax = false;


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
//        $form->addContainers($this->array, $domain);
        $this->attachFormContainers($form, $domain);

        if($this->ajax) {
            $form->getElementPrototype()->addAttributes(['class' => 'ajax']);
        }

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

            \Tracy\Debugger::log($e);
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
                if ($this->getRedirectParameters() == 'url') {
                    $form->getPresenter()->redirectUrl($this->getRedirectTo());
                } else {
                    $form->getPresenter()->redirect($this->getRedirectTo(), $this->getRedirectParameters());
                }
            }
        } catch (\Exception $e) {
            if ($e instanceof \Nette\Application\AbortException) {
                throw $e;
            }

            \Tracy\Debugger::log($e);
            $form->addError($e->getMessage());
        }
    }

    /**
     * Redirect to
     *
     * @param string $to
     * @param array $parameters
     */
    public function redirectTo($to, $parameters = [])
    {
        $this->redirect = $to;
        $this->redirectParameters = $parameters;
    }

    /**
     * Return redirect to
     *
     * @return string
     */
    public function getRedirectTo()
    {
        return $this->redirect;
    }

    /**
     * Return redirect parameters
     *
     * @return array
     */
    public function getRedirectParameters()
    {
        return $this->redirectParameters;
    }

    /**
     * Set ajax
     *
     * @param bool $enabled     enabled
     */
    public function setAjax($enabled)
    {
        if(!is_bool($enabled)) {
            throw new \InvalidArgumentException("setAjax function only accepts boolean. Input was: " . $enabled);
        }

        $this->ajax = $enabled;

        return $this;
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

                if($container instanceof Containers\BaseContainer) {
                    $form->addComponent($container, $containerName);
                    $this->setDefaultValue($form, $container);
                } else if($container instanceof Groups\BaseGroup) {
                    if(isset($item['parameters']['tag'])) {
                        $container->setTag($item['parameters']['tag']);
                    }
                    if(isset($item['parameters']['attributes'])) {
                        $container->setAttributes($item['parameters']['attributes']);
                    }
                    $form->addBaseGroup($container);
                } else if($container instanceof Tabs\BaseTab) {
                    if(isset($item['parameters']['tag'])) {
                        $container->setTag($item['parameters']['tag']);
                    }
                    if(isset($item['parameters']['attributes'])) {
                        $container->setAttributes($item['parameters']['attributes']);
                    }
                    $form->addBaseTab($container);
                }
            }
        }
    }

    /**
     * Set default value
     *
     * @param BaseForm $form form
     * @param BaseContainer $container container
     */
    protected function setDefaultValue($form, $container)
    {

    }

}
