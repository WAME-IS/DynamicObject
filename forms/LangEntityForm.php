<?php

namespace Wame\DynamicObject\Forms;

class LangEntityForm extends EntityForm
{
    /** @var BaseEntity[] */
    private $langEntities = [];
    
    /** @var BaseEntity */
    private $langEntity;
    
    
    /**
     * Get lang entity
     * 
     * @return BaseEntity
     */
    public function getLangEntity($lang = null)
    {
        $lang = $lang ?: $this->getRepository()->lang;
        
        if(!isset($this->langEntities[$lang])) {
            $this->langEntity = $this->repository->getNewLangEntity();
        }
        return $this->langEntity;
    }
    
    /**
     * Set lang entity
     * 
     * @param BaseEntity $langEntity    entity
     * @return LangEntityForm   this
     */
    public function setLangEntity(BaseEntity $langEntity)
    {
        $this->langEntity = $langEntity;
        
        return $this;
    }
    
}
