<?php

namespace Wame\DynamicObject\Forms\Groups;

use Nette\Forms\ControlGroup;
use Nette\Utils\Html;
use Wame\DynamicObject\Forms\Groups\BaseGroup;

abstract class BaseGroup extends ControlGroup
{
    /** @var array */
    private $buttons = [];
    
    /** @var BaseForm */
    protected $parent;
    
    /** @var string */
    private $tag = 'fieldset';
    
    /** @var string */
    private $width = 'col-xs-12';
    
    /** @var array */
    private $attributes = ['class' => []];
    
    
    use \Wame\Core\Traits\TRegister;
    
    use \Wame\DynamicObject\Traits\TCurrentTab;
    
    
    public function __construct()
    {
        parent::__construct();
    }
    
    
    /**
     * Set tag
     * 
     * @param string $tag   tag
     * @return BaseGroup
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
        
        return $this;
    }
    
    /**
     * Set attributes
     * 
     * @param array $attributes attributes
     * @return BaseGroup
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        
        return $this;
    }
    
    /**
     * Set attribute
     * 
     * @param string $name  attribute name
     * @param mixin $value  attribute value
     * @return BaseGroup
     */
    public function setAttribute($name, $value = true)
    {
        $this->attributes[$name] = $value;
        
        return $this;
    }
    
    /**
     * Get attributes
     * 
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
    
    /**
     * Get attribute
     * 
     * @param string $name  attribute name
     * @return array
     */
    public function getAttribute($name)
    {
        return $this->attributes[$name];
    }
    
    /**
     * Add class
     * 
     * @param string $class
     * @return BaseGroup
     */
    public function addClass($class)
    {
        $this->attributes['class'][] = $class;
        
        return $this;
    }
    
    /**
     * Set group width (col-xs-12, col-sm-6, col-lg-4...)
     * 
     * @param string $width
     * @return BaseGroup
     */
    public function setWidth($width)
    {
        $this->width = $width;
        
        return $this;
    }
    
    /**
     * Get group width
     * 
     * @return string
     */
    public function getWidth()
    {
        return $this->width;
    }
    
    /**
     * Get tag
     * 
     * @return Html
     */
    public function getTag()
    {
        return Html::el($this->tag);
    }
    
    /**
     * Add button
     * 
     * @param string $text  text
     * @param string $href  href
     * @param array $params params
     * @param string $icon  icon
     */
    public function addButton($text, $href, $params = [], $icon = null)
    {
        $this->buttons[] = [
            "href" => $href, 
            "text" => $text, 
            "icon" => $icon,
            "params" => $params
        ];
        
        return $this;
    }
    
    /**
     * Get buttons
     * 
     * @return array
     */
    public function getButtons()
    {
        return $this->buttons;
    }
    
    /**
     * Get text
     * 
     * @return string
     */
    public function getText() {}
    
    /**
     * Set parent
     * 
     * @param BaseForm $parent  parent
     * @return BaseGroup
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        
        return $this;
    }
    
    /**
     * Get parent
     * 
     * @return BaseForm
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    /**
     * Configure
     */
    public function configure() {}
    
}