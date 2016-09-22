<?php

namespace Wame\DynamicObject\Forms\Containers;

use Nette;
use Nette\Forms\Container;
use Nette\Application\UI;
use Wame\Utils\Latte\FindTemplate;
use Wame\Utils\Strings;

abstract class BaseContainer extends Container 
{
    /** @var UI\ITemplateFactory */
    private $templateFactory;

    /** @var UI\ITemplate */
    private $template;

    /** @var string */
    private $templateFile;


    public function __construct()
    {
        parent::__construct();
        
        $this->monitor('Nette\Forms\Form');
    }

	
    /**
     * Inject TemplateFactory
     * 
     * @param \Nette\Application\UI\ITemplateFactory $templateFactory
     */
    public function injectTemplateFactory(UI\ITemplateFactory $templateFactory) 
    {
        $this->templateFactory = $templateFactory;
    }
    
    /**
     * Form container processing
     * 
     * @param UI\Form $form
     * @param array $values
     */
    public function formContainerSucceeded($form, $values)
    {
        if ($form->getEntity()->getId()) {
            $this->update($form, $values);
        } else {
            $this->create($form, $values);
        }
    }
    
    /**
     * Render
     */
    public function render() 
	{
		$this->template = $this->getTemplate();
        $this->template->_form = $this->getForm();
        $this->template->render($this->getTemplateFile());
    }
    
    /**
     * https://api.nette.org/2.3.7/source-Application.UI.Control.php.html#45
     */
    public function getTemplate() 
    {
      if ($this->template === null) {
            $value = $this->createTemplate();
            
            if (!$value instanceof UI\ITemplate && $value !== null) {
                $class2 = get_class($value); $class = get_class($this);
                
                throw new Nette\UnexpectedValueException("Object returned by $class::createTemplate() must be instance of Nette\\Application\\UI\\ITemplate, '$class2' given.");
            }
            
            $this->template = $value;
        }
        
        return $this->template;
    }
    
    /**
	 * Set form container template file
	 * 
	 * @param string $template
	 * @return \Wame\DynamicObject\Forms\BaseFormContainer
	 */
	public function setTemplateFile($template)
	{
		$this->templateFile = $template;

		return $this;
	}
	
	/**
	 * Get template file path
	 * 
	 * @return string
	 */
	public function getTemplateFile()
	{
		$filePath = dirname($this->getReflection()->getFileName());
		$dir = explode(DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'wame' . DIRECTORY_SEPARATOR, $filePath, 2)[1];
		
		$findTemplate = new FindTemplate($dir, $this->templateFile);
		$file = $findTemplate->find();
		
		if (!$file) {
			throw new \Exception(sprintf(_('Template %s %s can not be found in %s.'), $this->templateFile, FindTemplate::DEFAULT_TEMPLATE, $dir));
		}
        
		return $file;
	}
    
    /**
     * Post update
     * 
     * @param Form $form    form
     * @param array $values values
     */
    public function postUpdate($form, $values) {}
    
    /**
     * Post create
     * 
     * @param Form $form    form
     * @param array $values values
     */
    public function postCreate($form, $values) {}
    
    /**
     * Update
     * 
     * @param UI\Form $form form
     * @param array $values values
     */
    public function update($form, $values) {}
    
    /**
     * Create
     * 
     * @param UI\Form $form form
     * @param array $values values
     */
    public function create($form, $values) {}
    
    
    /**
     * Attached
     * 
     * @param type $object
     */
    protected function attached($object)
    {
        parent::attached($object);
        
        if ($object instanceof Nette\Forms\Form) {
            $this->currentGroup = $this->getForm()->getCurrentGroup();
			
            // TODO: co s tymto
			if (!$this->currentGroup) {
				$this->getForm()->addGroup();
			}

            $this->configure();
			
 			$this->appendFormContainerToCurrentGroup();
            
            if ($object instanceof UI\Form) {
                $object->onSuccess[] = function($form) {
                    $this->formContainerSucceeded($form, $this->getValues());
                };
            }
        }
    }
    
	/**
	 * Create template
	 * 
	 * @return UI\ITemplateFactory
	 */
    protected function createTemplate() 
    {
        /** @var UI\ITemplateFactory $templateFactory */
        $templateFactory = $this->templateFactory ?: $this->lookup(UI\Presenter::class)->getTemplateFactory();

        return $templateFactory->createTemplate(null);
    }
    
    /**
     * Configure
     */
    abstract protected function configure();
    
    
    /**
     * Append form container to current group
     * 
     * @return \Wame\DynamicObject\Forms\Containers\BaseContainer
     */
    private function appendFormContainerToCurrentGroup()
	{
		$this->currentGroup = $this->getForm()->getCurrentGroup();
		
		if ($this->currentGroup) {
			$formContainerName = Strings::getClassName($this);
			
			if ($this->currentGroup->getOption('formContainers')) {
				$formGroups = $this->currentGroup->getOption('formContainers');

				$formGroups[] = $formContainerName;
			} else {
				$formGroups = [$formContainerName];
			}

			$this->currentGroup->setOption('formContainers', $formGroups);
		}
		
		return $this;
	}
    
}