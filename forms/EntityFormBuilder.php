<?php

namespace Wame\DynamicObject\Forms;

use Nette\Application\UI\Form;
use Wame\Core\Entities\BaseEntity;
use Wame\Core\Repositories\BaseRepository;

/**
 * Class EntityFormBuilder
 *
 * @package Wame\DynamicObject\Forms
 */
class EntityFormBuilder extends BaseFormBuilder
{
    const ACTION_CREATE = 'create';
    const ACTION_EDIT = 'edit';


    /** @var BaseEntity */
    protected $entity;

    /** @var BaseRepository */
    protected $repository;
    
    /** @var boolean */
    protected $persist = true;


    /** {@inheritDoc} */
    public function build($domain = null)
    {
        $form = $this->createForm();

        if($this->entity) {
            $form->setEntity($this->entity);
            unset($this->entity);
        }

        $form->setRenderer($this->getFormRenderer());
        $this->attachFormContainers($form, $domain);

        if($this->ajax) {
            $form->getElementPrototype()->addAttributes(['class' => 'ajax']);
        }

        $form->onSuccess[] = [$this, 'formSucceeded'];
        $form->onPostSuccess[] = [$this, 'formPostSucceeded'];

        return $form;
    }

    /**
     * Set entity
     *
     * @param BaseEntity $entity    entity
     * @return $this
     */
    public function setEntity(BaseEntity $entity = null)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Set repository
     *
     * @param BaseRepository $repository    repository
     */
    public function setRepository(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    /** {@inheritDoc} */
    public function submit(BaseForm $form, array $values)
    {
        $entity = $form->getEntity();

        if($entity->id) {
            $entity = $this->update($form, $values);
            
            if($this->persist) {
                $this->getRepository()->update($entity);
            }
            $this->getRepository()->onUpdate($form, $values, $entity);

            $form->getPresenter()->flashMessage(_('Successfully updated.'), 'success');
        } else {
            $entity = $this->create($form, $values);
            
            if($this->persist) {
                $this->getRepository()->create($entity);
            }
            $this->getRepository()->onCreate($form, $values, $entity);

            $form->getPresenter()->flashMessage(_('Successfully created.'), 'success');
        }

        // TODO: zistit ci sa neda presunut do postSubmit a flushovat len ked je to nutne
        $form->getRepository()->entityManager->flush();
    }

    /** {@inheritDoc} */
    public function postSubmit(BaseForm $form, array $values)
    {
        $entity = $form->getEntity();

        if($entity->id) {
            $entity = $this->postUpdate($form, $values);
        } else {
            $entity = $this->postCreate($form, $values);
        }
    }
    
    /**
     * Enable persist
     * 
     * @param type $enable
     * @return \Wame\DynamicObject\Forms\EntityFormBuilder
     */
    public function persist($enable)
    {
        $this->persist = $enable;
        
        return $this;
    }


    /** {@inheritDoc} */
    protected function createForm()
    {
        $form = new EntityForm;
        $form->setRepository($this->getRepository());

        return $form;
    }


    /**
     * Create
     * 
     * @param Form $form		form
     * @param array $values		values
     * @return BaseEntity       entity
     */
    protected function create($form, $values)
    {
        return $form->getEntity();
    }

    /**
     * Update
     * 
     * @param Form $form		form
     * @param array $values     values
     * @return BaseEntity       entity
     */
    protected function update($form, $values)
    {
        return $form->getEntity();
    }

    /**
     * Post create
     *
     * @param BaseForm $form    form
     * @param array $values     values
     * @return BaseEntity
     */
    protected function postCreate(BaseForm $form, array $values)
    {
        return $form->getEntity();
    }

    /**
     * Post update
     *
     * @param BaseForm $form    form
     * @param array $values     values
     * @return BaseEntity
     */
    protected function postUpdate(BaseForm $form, array $values)
    {
        return $form->getEntity();
    }

    /**
     * Get repository
     * 
     * @return  BaseRepository  repository
     */
    protected function getRepository()
    {
        return $this->repository;
    }

    /** {@inheritDoc} */
    protected function setDefaultValue($form, $container)
    {
        $entity = $form->getEntity();
        if ($entity->id && method_exists($container, 'setDefaultValues')) {
            $container->setDefaultValues($entity);
        }
    }

}
