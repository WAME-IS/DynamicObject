<?php

namespace Wame\DynamicObject\Forms;

use Nette\Application\UI\Form;
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
        
        $entity = $form->getEntity();
        
		$form->setRenderer($this->getFormRenderer());
		$this->attachFormContainers($form, $domain);
        
//        if($entity->id) {
//            if($this->getUpdateText()) {
//                $form->addSubmit('submit', $this->getUpdateText());
//            }
//        } else {
//            if($this->getCreateText()) {
//                $form->addSubmit('submit', $this->getCreateText());
//            }
//        }
        
        $form->onSuccess[] = [$this, 'formSucceeded'];
        $form->onError[] = [$this, 'formError'];
        
		return $form;
	}
    
    public function formError($form)
    {
        \Tracy\Debugger::barDump($form);
        \Tracy\Debugger::barDump($form->getErrors());
    }


    /**
     * Set entity
     * 
     * @param BaseEntity $entity    entity
     * @return \Wame\DynamicObject\Forms\EntityFormBuilder
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
        
        return $this;
    }
    
	/** {@inheritDoc} */
    public function submit($form, $values)
    {
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
     * Get repository
     * 
     * @return  BaseRepository  repository
     */
    abstract function getRepository();
    
    /**
     * Get update text
     * 
     * @return string
     */
    protected function getUpdateText()
    {
        return _('Update');
    }
    
    /**
     * Get create text
     * 
     * @return string
     */
    protected function getCreateText()
    {
        return _('Create');
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
