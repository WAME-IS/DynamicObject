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
        
        if(!isset($this->langEntities[$lang])) {
            $this->langEntities[$lang] = $this->repository->getNewLangEntity();
        }
        return $this->langEntities[$lang];
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
