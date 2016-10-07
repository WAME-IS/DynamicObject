<?php

namespace Wame\DynamicObject\Forms;

class LangEntityForm extends EntityForm
{
    /** @var BaseEntity[] */
    private $langEntities = [];
    
    
    /**
     * Get lang entity
     * 
     * @return BaseEntity
     */
    public function getLangEntity($lang = null)
    {
        $lang = $lang ?: $this->getRepository()->lang;
        
        $entity = $this->getEntity();
        
        if(!$entity->getCurrentLang()) {
            $entity->setCurrentLang($lang);
            
            $langEntity = $this->getRepository()->getNewLangEntity();
            $langEntity->setLang($lang);
            
            $entity->addLang($lang, $langEntity);
        }
        
        
        return $entity->getCurrentLangEntity();
    }
    
    /**
     * Set lang entity
     * 
     * @param BaseEntity $langEntity    entity
     * @return LangEntityForm   this
     */
    public function setLangEntity(BaseEntity $langEntity, $lang = null)
    {
        $lang = $lang ?: $this->getRepository()->lang;
        $this->langEntities[$lang] = $langEntity;
        
        return $this;
    }
    
}
