<?php

namespace Wame\DynamicObject\Forms;

use Nette\Application\UI\Form;
use Tracy\Debugger;
use Wame\Core\Entities\BaseEntity;
use Wame\DynamicObject\Forms\BaseFormBuilder;

abstract class EntityFormBuilder extends BaseFormBuilder
{
    const ACTION_CREATE = 'create';
	const ACTION_EDIT = 'edit';
	
    
    /** @var BaseEntity */
    protected $entity;
    
    
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
    public function setEntity(BaseEntity $entity)
    {
        $this->entity = $entity;
        
        return $this;
    }
    
	/** {@inheritDoc} */
    public function submit(BaseForm $form, array $values)
    {
        Debugger::barDump("submit");

        $entity = $form->getEntity();
        
        if($entity->id) {
            $entity = $this->update($form, $values);

            $this->getRepository()->onUpdate($form, $values, $entity);

            $form->getPresenter()->flashMessage(_('Successfully updated.'), 'success');
        } else {
            $entity = $this->create($form, $values);
            $this->getRepository()->create($entity);
            $this->getRepository()->onCreate($form, $values, $entity);

            $form->getPresenter()->flashMessage(_('Successfully created.'), 'success');
        }
    }

    public function postSubmit(BaseForm $form, array $values)
    {
        Debugger::barDump("postSubmit");

        $entity = $form->getEntity();

        if($entity->id) {
            $entity = $this->postUpdate($form, $values);
        } else {
            $entity = $this->postCreate($form, $values);
        }
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

    protected function postCreate(BaseForm $form, array $values)
    {
        return $form->getEntity();
    }

    protected function postUpdate(BaseForm $form, array $values)
    {
        return $form->getEntity();
    }
    
    /**
     * Get repository
     * 
     * @return  BaseRepository  repository
     */
    abstract function getRepository();
    
    /** {@inheritDoc} */
    protected function setDefaultValue($form, $container)
    {
        $entity = $form->getEntity();
        if ($entity->id && method_exists($container, 'setDefaultValues')) {
            $container->setDefaultValues($entity);
        }
    }
    
}
