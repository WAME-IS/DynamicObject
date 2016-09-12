# Form / DynamicObject

![build](https://img.shields.io/badge/build-passing-green.svg)
![unstable](https://img.shields.io/badge/unstable-0.0.1-orange.svg)

Formulare


## Table of Contents

- [Security](#security)
- [Background](#background)
- [Installation](#installation)
- [Usage](#usage)
- [FAQ](#faq)
- [Contribute](#contribute)
- [License](#license)


## Security


## Background




## Installation

Add the bundle to your dependecies:
```
composer require wame/DynamicObject:0.0.1
```

composer.json:
```
{
    "require": {
        "wame/DynamicObject" : "0.0.1"
    }
}
```


## Usage

*MyFormBuilder*
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
        return $this->parameterRepository;
    }
	
}
```

*config.neon*
```
services:
    ParameterFormBuilder:
        class: Wame\MyModule\Forms\MyFormBuilder
        setup:
            - add(@Wame\DynamicObject\Forms\Containers\ITitleFormContainerFactory, 'TitleFormContainer', {priority: 90})
```

*container*
```
<?php

namespace Wame\DynamicObject\Forms\Containers;

use Wame\DynamicObject\Registers\Types\IBaseFormContainerType;

interface ITitleFormContainerFactory extends IBaseFormContainerType
{
	/** @return TitleFormContainer */
	public function create();
}

class TitleFormContainer extends BaseFormContainer
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
