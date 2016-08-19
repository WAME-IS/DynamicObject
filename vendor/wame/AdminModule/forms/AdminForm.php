<?php

namespace Wame\DynamicObject\Vendor\Wame\AdminModule\Forms;

use Nette\Security\User;
use Nette\Application\UI\Form;
use Wame\Core\Forms\FormFactory;
use Wame\ParameterModule\Entities\ParameterEntity;
use Wame\UserModule\Repositories\UserRepository;

abstract class AdminForm extends FormFactory
{
	const ACTION_CREATE = 'create';
	const ACTION_EDIT = 'edit';
	
	
	public function build()
	{
		$form = $this->createForm();
        
		if($this->getEntity()->id) {
			$form->addSubmit('submit', _('Update'));
			
			$this->setDefaultValues();
		} else {
			$form->addSubmit('submit', _('Create'));
		}
		
		$form->onSuccess[] = [$this, 'formSucceeded'];
		
		return $form;
	}
	
	
	public function formSucceeded(Form $form, $values)
	{
		$presenter = $form->getPresenter();

		try {
            $entity = $this->getEntity();
            
            dump($entity); exit;
            
			if($entity->id) {
				$entity = $this->update($values);
                
				$this->getRepository()->onUpdate($form, $values, $entity);

				$presenter->flashMessage(_('Successfully updated.'), 'success');
			} else {
				$entity = $this->create($values);

				$this->getRepository()->onCreate($form, $values, $entity);

				$presenter->flashMessage(_('Successfully created.'), 'success');
			}
            
			$presenter->redirect('this');
		} catch (\Exception $e) {
			if ($e instanceof \Nette\Application\AbortException) {
				throw $e;
			}
			
			$form->addError($e->getMessage());
		}
	}
	
//	/**
//	 * Create parameter
//	 * 
//	 * @param array $values		values
//	 * @return ParameterEntity	prameter
//	 */
//	public function create($values)
//	{
//        $entity = $this->getEntity();
//        $this->fill($entity, $values);
//        
//        return $this->getRepository()->create($entity);
//	}
//	
//	/**
//	 * Update parameter
//	 * 
//	 * @param array $values
//	 * @return ComponentEntity
//	 */
//	public function update($values)
//	{
//        $entity = $this->getEntity();
//        $this->fill($entity, $values);
//        
//        return $this->getRepository()->update($entity);
//	}
	
	/**
	 * Create
	 * 
	 * @param array $values		values
	 * @return ParameterEntity	prameter
	 */
    abstract function create($values);
    
	/**
	 * Update
	 * 
	 * @param array $values
	 * @return ComponentEntity
	 */
    abstract function update($values);
    
    /**
     * Get entity
     * 
     * @return  BaseEntity  entity
     */
    abstract function getEntity();
    
    /**
     * Get repository
     * 
     * @return  BaseRepository  repository
     */
    abstract function getRepository();
    
    
//    /**
//     * Fill entity
//     * 
//     * @param BaseEntity    entity
//     * @return BaseEntity
//     */
//    abstract function fill(\Wame\Core\Entities\BaseEntity $entity, array $values);
    
}
