# Form / DynamicObject

![build](https://img.shields.io/badge/build-passing-green.svg)
![unstable](https://img.shields.io/badge/unstable-0.0.1-orange.svg)

Formulare


## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [FAQ](#faq)
- [Contribute](#contribute)
- [License](#license)


## Installation

Add the bundle to your dependecies:
```
composer require wame/DynamicObject:0.0.1
```

composer.json:
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

*config.neon (Config)*
```
services:
    MyFormBuilder:
        class: Wame\MyModule\Forms\MyFormBuilder
        setup:
            - add(@Wame\DynamicObject\Forms\Containers\ITitleContainerFactory, 'TitleContainer', {priority: 90})
```

*ITitleContainerFactory (Container)*
```
<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseContainer;

interface ITitleContainerFactory extends IBaseContainer
{
	/** @return TitleFormContainer */
	public function create();
}

class TitleFormContainer extends BaseContainer
{
    /** {@inheritDoc} */
    public function configure() 
	{
		$this->addText('title', _('Title'))
				->setRequired(_('Please enter title'));
    }

    /** {@inheritDoc} */
	public function setDefaultValues($entity, $langEntity)
	{
		$this['title']->setDefaultValue($langEntity->getTitle());
	}

    /** {@inheritDoc} */
    public function create($form, $values)
    {
        $form->getLangEntity()->setTitle($values['title']);
    }

    /** {@inheritDoc} */
    public function update($form, $values)
    {
        $form->getLangEntity()->setTitle($values['title']);
    }

}
```


## FAQ


## Contribute


## License
