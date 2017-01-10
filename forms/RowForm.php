<?php

namespace Wame\DynamicObject\Forms;

use Wame\Core\Entities\BaseEntity;
use Wame\Core\Repositories\BaseRepository;

class RowForm extends BaseForm
{
    /** @var BaseRepository */
    protected $repository;

    /** @var BaseEntity[] */
    protected $entities;


    /**
     * Get entity
     *
     * @param string $key   key
     * @return BaseEntity
     */
    public function getEntity(string $key)
    {
        // if not found entity by key return new entity
        if(!isset($this->entities) || !isset($this->entities[$key])) {
            return $this->repository->getNewEntity();
        }

        return $this->entities[$key];
    }

    /**
     * Get entities
     *
     * @return BaseEntity[]
     */
    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * Set entities
     *
     * @param array $entities   entities
     * @return $this
     */
    public function setEntities(array $entities)
    {
        $this->entities = $entities;

        return $this;
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
     * Set repository
     *
     * @param BaseRepository $repository    repository
     * @return $this
     */
    public function setRepository(BaseRepository $repository)
    {
        $this->repository = $repository;

        return $this;
    }

}