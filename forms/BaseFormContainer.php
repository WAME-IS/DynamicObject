<?php

namespace Wame\DynamicObject\Forms;

use Nette;
use Nette\Forms\Container;
use Nette\Application\UI;
use Wame\Utils\Latte\FindTemplate;

abstract class BaseFormContainer extends Container 
{
	const SWITCH_NO = 0;
	const SWITCH_YES = 1;
	
    /** @var UI\ITemplateFactory */
    private $templateFactory;

    /** @var UI\ITemplate */
    private $template;

    /** @var string */
    private $templateFile;
	
	/** @var array */
	public $yesOrNo;


    public function __construct()
    {
        parent::__construct();
        
        $this->monitor('Nette\Forms\Form');
		
		$this->yesOrNo = [self::SWITCH_YES => _('Yes'), self::SWITCH_NO => _('No')];
    }

	
    public function injectTemplateFactory(UI\ITemplateFactory $templateFactory) 
    {
        $this->templateFactory = $templateFactory;
    }


    abstract protected function configure();

    
    protected function attached($object)
    {
        parent::attached($object);
        
        if ($object instanceof Nette\Forms\Form) {
            $this->currentGroup = $this->getForm()->currentGroup;
            $this->configure();
        }
    }

	
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
	 * Format DateTime to string
	 * 
	 * @param \DateTime $date
	 * @param string $format
	 * @return string
	 */
	public function formatDate($date, $format = 'Y-m-d H:i:s')
	{
        if ($date) {
            $return = $date->format($format);
        } else {
            $return = '';
        }
         
        return $return;
	}
	
	
	/**
	 * Get default value
	 * 
	 * @param string $name
	 * @return mixed
	 */
	public function getDefault($name)
	{
		if (method_exists($this, 'getDefaults')) {
			if (isset($this->getDefaults()[$name])) {
				return $this->getDefaults()[$name];
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
    
}