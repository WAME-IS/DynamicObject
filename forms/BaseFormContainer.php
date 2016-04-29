<?php

namespace Wame\DynamicObject\Forms;

use Nette;
use Nette\Forms\Container;
use Nette\Utils\DateTime;
use Nette\Application\UI;

abstract class BaseFormContainer extends Container 
{
    /** @var UI\ITemplateFactory */
    private $templateFactory;

    /** @var UI\ITemplate */
    private $template;


    public function __construct()
    {
        parent::__construct();
        
        $this->monitor('Nette\Forms\Form');
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
    
}