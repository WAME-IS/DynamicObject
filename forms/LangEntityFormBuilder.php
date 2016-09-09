<?php

namespace Wame\DynamicObject\Forms;

use Wame\DynamicObject\Forms\LangEntityForm;

/**
 * Lang entity form builder
 * 
 * @package DynamicOBject
 * @author  WAME s.r.o. <info@wame.sk>
 * @version 0.0.1
 * @access  public
 */
abstract class LangEntityFormBuilder extends EntityFormBuilder
{
    /** @var BaseEntity */
    protected $langEntity;
    
    
    /**
     * Set entity
     * 
     * @param BaseEntity $langEntity    entity
     * @return \Wame\DynamicObject\Forms\EntityFormBuilder
     */
    public function setLangEntity($langEntity)
    {
        $this->langEntity = $langEntity;
        
        return $this;
    }
    
    
    /** {@inheritDoc} */
    protected function create($form, $values)
    {
        $lang = $this->getRepository()->lang;
        
        $entity = $form->getEntity();
        $entity->setCurrentLang($lang);
        $langEntity = $form->getLangEntity();
        
        $langEntity->setLang($lang);
        $entity->addLang($lang, $langEntity);
        
        
        \Tracy\Debugger::barDump($entity);
        
        return $entity;
    }
    
    /** {@inheritDoc} */
	protected function createForm()
	{
		$form = new LangEntityForm;
        $form->setRepository($this->getRepository());
		
		return $form;
	}
    
    /** {@inheritDoc} */
    protected function setDefaultValue($form, $container)
    {
        $entity = $form->getEntity();
        $langEntity = $form->getLangEntity();
        
        if ($entity->id && method_exists($container, 'setDefaultValues')) {
            $container->setDefaultValues($entity, $langEntity);
        }
    }
    
}
