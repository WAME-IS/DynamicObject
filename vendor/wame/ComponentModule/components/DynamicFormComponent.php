<?php

namespace Wame\DynamicObject\Vendor\Wame\ComponentModule;

use Nette\Application\LinkGenerator;
use Wame\ComponentModule\Registers\IComponent;
use Wame\DynamicObject\Components\IDynamicFormControlFactory;
use Wame\MenuModule\Models\Item;

class DynamicFormComponent implements IComponent
{
    /** @var LinkGenerator */
    private $linkGenerator;

    /** @var IDynamicFormControlFactory */
    private $IDynamicFormControlFactory;


    public function __construct(
        LinkGenerator $linkGenerator, IDynamicFormControlFactory $IDynamicFormControlFactory
    ) {
        $this->linkGenerator = $linkGenerator;
        $this->IDynamicFormControlFactory = $IDynamicFormControlFactory;
    }


    /** {@inheritdoc} */
    public function addItem()
    {
        $item = new Item();
        $item->setName($this->getName());
        $item->setTitle($this->getTitle());
        $item->setDescription($this->getDescription());
        $item->setLink($this->getLinkCreate());
        $item->setIcon($this->getIcon());

        return $item->getItem();
    }

    /** {@inheritdoc} */
    public function getName()
    {
        return 'dynamicForm';
    }

    /** {@inheritdoc} */
    public function getTitle()
    {
        return _('Dynamic Form');
    }

    /** {@inheritdoc} */
    public function getDescription()
    {
        return _('Create dynamic form component');
    }

    /** {@inheritdoc} */
    public function getIcon()
    {
        return 'fa fa-id-card-o';
    }

    /** {@inheritdoc} */
    public function getLinkCreate()
    {
        return $this->linkGenerator->link('Admin:DynamicFormControl:create');
    }

    /** {@inheritdoc} */
    public function getLinkDetail($componentEntity)
    {
        return $this->linkGenerator->link('Admin:DynamicFormControl:edit', ['id' => $componentEntity->id]);
    }

    /** {@inheritdoc} */
    public function createComponent()
    {
        $control = $this->IDynamicFormControlFactory->create();

        return $control;
    }

}
