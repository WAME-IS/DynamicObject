# Form / DynamicObject

![build](https://img.shields.io/badge/build-passing-green.svg)
![unstable](https://img.shields.io/badge/unstable-0.0.1-orange.svg)

Module which handle forms.


## Table of Contents

[TOC]


## Installation

*command:*
```
$ composer require wame/DynamicObject:0.0.1
```

or

*composer.json:*
```
{
    // ...
    "require": {
        // ...
        "wame/DynamicObject" : "0.0.1"
    }
}
```


## Usage

### Forms

To obtaining form component, module provide builders. Each builder provide functionality to handle different tasks.

#### BaseFormBuilder

Builder which doesn't save anything to database, there is nothing like `create`/`update` ... just `submit`.

*Builder:*
```
class FilterFormBuilder extends BaseFormBuilder
{
    /** {@inheritDoc} */
    public function submit($form, $values)
    {
        // code
    }
    
}
```

*Component:*
```
protected function createComponentSortForm()
{
    $form = $this->articleFormBuilder->build();

    return $form;
}
```

#### EntityFormBuilder

Improved builder that handle single entity. Edit provide entity which is used for container's default values and create empty entity, which is filled by containers.

Builder must implement `getRepository` method, that is used to working with entity.

In order to handle default values, you need call `setEntity`.

#### LangEntityFormBuilder

Builder working with translatable data.

In order to handle default values, you need call `setEntity` and `setLangEntity`.

*MyFormBuilder.php (FormBuilder)*
```
<?php

namespace Wame\MyModule\Forms;

use Wame\MyModule\Repositories\MyRepository;
use Wame\DynamicObject\Forms\LangEntityFormBuilder;

class MyFormBuilder extends LangEntityFormBuilder
{
	/** @var ParameterRepository */
	private $parameterRepository;
	
	
	public function __construct(ParameterRepository $parameterRepository)
    {
        parent::__construct();
        
		$this->parameterRepository = $parameterRepository;
	}
    
    
    /** {@inheritDoc} */
    public function getRepository()
    {
        return $this->myRepository;
    }
	
}
```

### Containers

Every form container shoud be in this structure: `forms\conintainers\<containerName>\<ContainerName>Container` (e.g.: `forms\containers\title\TitleContainer`), to achieve consistence .

*ITitleContainerFactory (Container)*
```
<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface ITitleContainerFactory extends IBaseContainer
{
	/** @return TitleContainer */
	public function create();
}

class TitleContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure() 
	{
		$this->addText('title', _('Title'))
				->setRequired(_('Please enter title'));
    }

    /** {@inheritDoc} */
	public function setDefaultValues($entity, $langEntity = null)
	{
        $this['title']->setDefaultValue($entity->getTitle());
	}

    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $entity = method_exists($form, 'getLangEntity') ? $form->getLangEntity(): $form->getEntity();
        $entity->setTitle($values['title']);
    }

    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $entity = method_exists($form, 'getLangEntity') ? $form->getLangEntity(): $form->getEntity();
        $entity->setTitle($values['title']);
    }

}
```

#### Config

**parameters:**
* priority - containers with higher priority are top
* domain - value that must be equals with value provided in `build` method

*config.neon (Config)*
```
services:
    MyFormBuilder:
        class: Wame\MyModule\Forms\MyFormBuilder
        setup:
            - add(@Wame\DynamicObject\Forms\Containers\ITitleContainerFactory, 'TitleContainer', {priority: 90})
```

#### Name

To prevent collision of `name` parameter, containers has format: `name="[<ContainerName>][<InputName>]"` (e.g.: `name="[TitleContainer][title]"`)

#### Templates

Forms can be rendered automatically or by `TemplateFormRender`, which render containers using latte templates.

Templates are located in same folder as container. Default name is `default.latte`.

*example:*
```
{var $title = $_form['TitleContainer']['title']}
<div class="form-group">
    {label $title/}
    <input class="form-control" n:name="$title">
</div>
```

#### Groups

It's possible create form group in container's method `configure`:

```
/** {@inheritDoc} */
public function configure() 
{
    $this->getForm()->addGroup(_('Short description'));
    // ...
}
```


## FAQ


## Contribute


## License
