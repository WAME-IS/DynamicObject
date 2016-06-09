<?php

namespace Wame\DynamicObject\Forms;

use Nette;
use Nette\Forms\Container;
use Nette\Application\UI;

abstract class BaseFormContainer extends Container 
{
	const SWITCH_NO = 0;
	const SWITCH_YES = 1;
	
    /** @var UI\ITemplateFactory */
    private $templateFactory;

    /** @var UI\ITemplate */
    private $template;
	
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

    
    abstract public function render();
    
    
//    abstract public function setDefaultValues();

    
    protected function attached($object)
    {
        parent::attached($object);
        
        if ($object instanceof Nette\Forms\Form) {
            $this->currentGroup = $this->getForm()->currentGroup;
            $this->configure();
        }
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

    
    protected function createTemplate() 
    {
        /** @var UI\ITemplateFactory $templateFactory */
        $templateFactory = $this->templateFactory ?: $this->lookup(UI\Presenter::class)->getTemplateFactory();

        return $templateFactory->createTemplate(null);
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