<?php

namespace Wame\DynamicObject\Forms;

use Nette;
use Nette\Application\UI\Form;
use Tracy\Debugger;
use Wame\DynamicObject\Forms\Groups\BaseGroup;

class BaseForm extends Form
{
    /** @var callable[]  function (Form $sender); Occurs when the form is submitted and successfully validated */
    public $onPostSuccess;
    
    /** @var BaseGroup */
    private $baseGroups = [];


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
    
    public function addContainers($containers, $domain = null)
    {
        $this->containers = $containers;
        $this->domain = $domain;
    }
    
    /**
	 * Add base group to form
     * 
	 * @param BaseGroup $group  group
	 * @param string $name      name
	 * @return BaseGroup
	 */
    public function addBaseGroup($group, $name = null)
    {
        $group->setParent($this);
        $this->setCurrentGroup($group);
        
        if(isset($name)) {
            return $this->baseGroups[$name] = $group;
        } else {
            return $this->baseGroups[] = $group;
        }
    }
    
    /**
	 * Returns all defined base groups
     * 
	 * @return BaseGroup[]
	 */
	public function getBaseGroups()
	{
		return $this->baseGroups;
	}
    
    /**
	 * Returns the specified base group
     * 
	 * @param  string  name
	 * @return BaseGroup
	 */
	public function getBaseGroup($name)
	{
		return isset($this->baseGroups[$name]) ? $this->baseGroups[$name] : NULL;
	}

}