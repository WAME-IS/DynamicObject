<?php

namespace Wame\DynamicObject\Forms;

use Nette;
use Nette\Application\UI\Form;
use Tracy\Debugger;

class BaseForm extends Form
{
    /** @var callable[]  function (Form $sender); Occurs when the form is submitted and successfully validated */
    public $onPostSuccess;


    /** {@inheritdoc} */
    public function fireEvents()
    {
        parent::fireEvents();

        if ($this->onPostSuccess !== NULL) {
            if (!is_array($this->onPostSuccess) && !$this->onPostSuccess instanceof \Traversable) {
                throw new Nette\UnexpectedValueException('Property Form::$onPostSuccess must be array or Traversable, ' . gettype($this->onPostSuccess) . ' given.');
            }
            foreach ($this->onPostSuccess as $handler) {
                $params = Nette\Utils\Callback::toReflection($handler)->getParameters();
                $values = isset($params[1]) ? $this->getValues($params[1]->isArray()) : NULL;
                Nette\Utils\Callback::invoke($handler, $this, $values);
                if (!$this->isValid()) {
                    $this->onError($this);
                    break;
                }
            }
        }
    }

//    /** @var bool */
//    private $useRenderer = false;
//    
//    
//    /** {@inheritDoc} */
//    protected function attached($presenter)
//    {
//        parent::attached($presenter);
//        
//        foreach($this->components as $component) {
//            if($component instanceof Containers\BaseContainer) {
//                $component->render();
//            }
//        }
//    }
//    
//    /** {@inheritDoc} */
//    public function render()
//    {
//        if($this->useRenderer) {
//            parent::render();
//        }
//    }

}