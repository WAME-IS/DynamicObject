<?php

namespace Wame\DynamicObject\Forms\Groups;

use Nette\Forms\ControlGroup;
use Nette\Utils\Html;
use Wame\Core\Traits\TRegister;
use Wame\DynamicObject\Forms\BaseForm;
use Wame\DynamicObject\Traits\TCurrentTab;

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
    
    
    use TRegister;
    use TCurrentTab;
    
    
    /**
     * Set tag
     * 
     * @param string $tag   tag
     * @return $this
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
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
        
        return $this;
    }
    
    /**
     * Set attribute
     * 
     * @param string $name  attribute name
     * @param bool $value  attribute value
     * @return $this
     */
    public function setAttribute(string $name, bool $value = true)
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
    public function getAttribute(string $name)
    {
        return $this->attributes[$name];
    }
    
    /**
     * Add class
     * 
     * @param string $class
     * @return $this
     */
    public function addClass(string $class)
    {
        $this->attributes['class'][] = $class;
        
        return $this;
    }
    
    /**
     * Set group width (col-xs-12, col-sm-6, col-lg-4...)
     * 
     * @param string $width
     * @return $this
     */
    public function setWidth(string $width)
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
     * @param string $text text
     * @param string $href href
     * @param array $params params
     * @param string $icon icon
     * @return $this
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
     * @return $this
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