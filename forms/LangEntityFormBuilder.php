<?php

namespace Wame\DynamicObject\Forms;

/**
 * Class LangEntityFormBuilder
 *
 * @package Wame\DynamicObject\Forms
 */
class LangEntityFormBuilder extends EntityFormBuilder
{
    /** @var BaseEntity */
    protected $langEntity;
    
    
    public function getLangEntity()
    {
        $langEntity = $this->getEntity()->getCurrentLangEntity();
        
        return $langEntity;
    }
    
    /**
     * Set lang entity
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
        // TODO: zapracovat iterovanie vsetkymi jazykmi
        $lang = $this->getRepository()->lang;
        
        $entity = $form->getEntity();
        $entity->setCurrentLang($lang);
        $langEntity = $form->getLangEntity();
        
        $langEntity->setLang($lang);
        $entity->addLang($lang, $langEntity);
        
        return $entity;
    }
    
//    /** {@inheritDoc} */
//    protected function update($form, $values)
//    {
//        // TODO: zapracovat iterovanie vsetkymi jazykmi
//        $lang = $this->getRepository()->lang;
//        
//        $entity = $form->getEntity();
//        
//        return $entity->getCurrentLangEntity();
//    }
    
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
