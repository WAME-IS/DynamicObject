<?php

namespace App\AdminModule\Presenters;

use Wame\Core\Presenters\Traits\UseParentTemplates;
use Wame\DynamicObject\Vendor\Wame\AdminModule\Forms\Containers\IContainerContainerFactory;

class DynamicFormControlPresenter extends AbstractComponentPresenter
{
    /** @var IContainerContainerFactory @inject */
    public $IContainerContainerFactory;


    use UseParentTemplates;
    

    /** {@inheritdoc} */
    protected function getComponentIdentifier()
    {
        return 'DynamicFormComponent';
    }

    /** {@inheritdoc} */
    protected function getComponentName()
    {
        return _('Dynamic Form component');
    }


    /** components ************************************************************/

    /** {@inheritdoc} */
    protected function createComponentForm()
    {
        return $this->context
            ->getService('Admin.ComponentFormBuilder')
            ->setEntity($this->entity)
//            ->add($this->IContainerGroupFactory, 'ComponentGroup', ['priority' => 9])
            ->add($this->IContainerContainerFactory, 'ContainerContainer', ['priority' => 8])
            ->build($this->id);
    }
 
}
