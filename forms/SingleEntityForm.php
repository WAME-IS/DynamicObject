<?php

namespace Wame\DynamicObject\Forms;

use Nette\Application\UI\Form;
use Wame\Core\Registers\PriorityRegister;
use Wame\DynamicObject\Registers\Types\IBaseFormContainerType;
use Wame\DynamicObject\Forms\BaseForm;

abstract class SingleEntityForm extends BaseForm
{
    /**
     * Build
     * 
     * @param string $domain    domain
     * @return Form
     */
	public function build($domain = null)
	{
		$form = $this->createForm($domain);
        
        if($this->getEntity()->id) {
            $form->addSubmit('submit', $this->getUpdateText());

            $this->setDefaultValues();
        } else {
            $form->addSubmit('submit', $this->getCreateText());
        }
        
        $form->onSuccess[] = [$this, 'formSucceeded'];
        
		return $form;
	}
	
    /**
     * Form succeeded
     * 
     * @param Form $form    form
     * @param array $values values
     * @throws \Exception
     */
	public function formSucceeded(Form $form, $values)
	{
		$presenter = $form->getPresenter();

		try {
            $this->submit($form, $values);
            
			$presenter->redirect('this');
		} catch (\Exception $e) {
			if ($e instanceof \Nette\Application\AbortException) {
				throw $e;
			}
			
			$form->addError($e->getMessage());
		}
	}
    
    
    /**
	 * Create Form
	 * 
	 * @return Form
	 */
	private function createForm($domain)
	{
		$form = new Form;
		
		$form->setRenderer(new \Tomaj\Form\Renderer\BootstrapVerticalRenderer);
		$this->attachFormContainers($form, $domain);
		
		return $form;
	}
    
    /**
     * Attach form containers
     * 
     * @param Form $form
     * @param string $domain
     */
    private function attachFormContainers(Form $form, $domain = null)
    {
        foreach($this->getByDomain($domain) as $name => $containerFactory)
        {
            $container = $containerFactory->create();
            $form->addComponent($container, $name); // TODO: default nazov
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
     * 
     * @param type $values
     */
    public function submit($form, $values)
    {
        $entity = $this->getEntity();
        
        if($entity->id) {
            $entity = $this->update($values);

            $this->getRepository()->onUpdate($form, $values, $entity);

            $presenter->flashMessage(_('Successfully updated.'), 'success');
        } else {
            $entity = $this->create($values);

            $this->getRepository()->onCreate($form, $values, $entity);

            $presenter->flashMessage(_('Successfully created.'), 'success');
        }
    }
    
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
    
    
    protected function isEditMode()
    {
        return $this->parameters['action'] == self::ACTION_EDIT;
    }
    
    protected function getUpdateText()
    {
        return _('Update');
    }
    
    protected function getCreateText()
    {
        return _('Create');
    }
    
}
