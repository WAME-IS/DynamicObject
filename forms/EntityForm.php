<?php

namespace Wame\DynamicObject\Forms;

use Wame\DynamicObject\Forms\BaseForm;
use Wame\Core\Entities\BaseEntity;
use Wame\Core\Repositories\BaseRepository;

class EntityForm extends BaseForm
{
    /** @var BaseEntity */
    private $entity;
    
    /** @var BaseRepository */
    private $repository;
    
    
    /**
     * Get entity
     * 
     * @return BaseEntity
     */
    public function getEntity()
    {
        if(!isset($this->entity)) {
            $this->entity = $this->repository->getNewEntity();
        }
        
        return $this->entity;
    }

    /**
     * Set entity
     * 
     * @param BaseEntity $entity    entity
     * @return EntityForm   this
     */
    public function setEntity(BaseEntity $entity)
    {
        $this->entity = $entity;
        
        return $this;
    }
    
    /**
     * Get repository
     * 
     * @return type
     */
    public function getRepository()
    {
        return $this->repository;
    }
    
    /**
     * Set repository
     * 
     * @param BaseRepository $repository
     */
    public function setRepository(BaseRepository $repository)
    {
        $this->repository = $repository;
        
        return $this;
    }
    
}