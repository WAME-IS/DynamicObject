<?php

namespace Wame\DynamicObject\Forms;

use Wame\Core\Entities\BaseEntity;
use Wame\Core\Repositories\BaseRepository;

class RowFormBuilder extends BaseFormBuilder
{
    const ACTION_CREATE = 'create';
    const ACTION_EDIT = 'edit';


    /** @var array */
    protected $criteria;

    /** @var BaseEntity[] */
    protected $entities;

    /** @var BaseRepository */
    protected $repository;

    /** @var bool */
    protected $persist = true;


    public function build($domain = null)
    {
        $form = $this->createForm();

        if($this->entities) {
            $form->setEntities($this->entities);
        } else if($this->criteria) {
            $form->setEntities($this->getEntities());
        }

        $form->setRenderer($this->getFormRenderer());
        $this->attachFormContainers($form, $domain);

        if($this->ajax) {
            $form->getElementPrototype()->addAttributes(['class' => 'ajax']);
        }

        $form->onSuccess[] = [$this, 'formSucceeded'];

        return $form;
    }

    /**
     * Set entities
     *
     * @param array $entities
     * @return $this
     */
    public function setEntities(array $entities)
    {
        $this->entities = $entities;

        return $this;
    }

    /**
     * Set criteria
     *
     * @param array $criteria criteria
     * @return $this
     */
    public function setCriteria(array $criteria)
    {
        $this->criteria = $criteria;

        return $this;
    }

    /** {@inheritdoc} */
    public function submit(BaseForm $form, array $values)
    {
        $entities = $form->getEntities();

        $this->getRepository()->onUpdate($form, $values, $entities);
    }

    /**
     * Enable persist
     *
     * @param bool $enable enable persist
     * @return $this
     */
    public function persist($enable)
    {
        $this->persist = $enable;

        return $this;
    }

    /** {@inheritdoc} */
    protected function createForm()
    {
        $form = new RowForm;
        $form->setRepository($this->getRepository());

        return $form;
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
     * @param BaseRepository $repository
     * @return $this
     */
    public function setRepository(BaseRepository $repository)
    {
        $this->repository = $repository;

        return $this;
    }

    public function getEntities()
    {
        if(!$this->entities) {
            $this->entities = $this->getRepository()->findAssoc($this->criteria, 'name');
        }

        return $this->entities;
    }

    protected function setDefaultValue($form, $container)
    {
        if(method_exists($container, 'setDefaultValues')) {
            $entity = null;
            $container->setDefaultValues($entity);
        }
    }

}