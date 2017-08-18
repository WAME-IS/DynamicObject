<?php

namespace Wame\DynamicObject\Forms;

use Wame\Core\Entities\BaseEntity;
use Wame\Core\Repositories\BaseRepository;


class EntityForm extends BaseForm
{
    /** @var BaseEntity */
    private $entity;
    
    /** @var BaseRepository */
    private $repository;

    /** @var BaseEntity|int|string */
    private $item;


    /** get ***********************************************************************************************************/

    /**
     * Get entity
     * 
     * @return BaseEntity
     */
    public function getEntity()
    {
        if (!isset($this->entity)) {
            $this->entity = $this->repository->getNewEntity();
        }
        
        return $this->entity;
    }


    /**
     * Get repository
     *
     * @return BaseRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }


    /**
     * Get item
     *
     * @return BaseEntity|int|string
     */
    public function getItem()
    {
        return $this->item;
    }


    /** set ***********************************************************************************************************/

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
     * Set repository
     *
     * @param BaseRepository $repository
     * @return $this
     */
    public function setRepository(BaseRepository $repository)
    {
        $this->repository = $repository;
        
        return $this;
    }


    /**
     * Set item
     *
     * @param BaseEntity|int|string $item
     * @return $this
     */
    public function setItem($item)
    {
        $this->item = $item;

        return $this;
    }
    
}
