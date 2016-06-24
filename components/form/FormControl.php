<?php 

namespace Wame\DynamicObject\Components;

use Nette\DI\Container;
use Nette\Utils\Strings;
use Wame\Utils\HttpRequest;
use Wame\Core\Components\BaseControl;


interface IFormControlFactory
{
	/** @return FormControl */
	public function create($formName);
}


class FormControl extends BaseControl
{
	/** @var Container */
	private $container;

	/** @var string */
	private $formName;

	/** @var int */
	private $id;


	public function __construct(
		$formName,
		Container $container,
		HttpRequest $httpRequest
	) {
		parent::__construct();
		
		$this->formName = $formName;
		$this->container = $container;
		$this->id = $httpRequest->getParameter('id');
	}


	public function render()
	{
		$formName = $this->formName;
		
		$form = $this->container->getService(Strings::firstUpper($formName));

		$this->addComponent($form->setId($this->id)->build(), $formName);
		
		$this->template->formName = $formName;
		$this->template->formContainers = $this->getFormContainers($form->sortFormContainers(), $formName);

        $this->getTemplateFile();
		$this->template->render();
	}
	
	
	private function getFormContainers($formContainers, $formName)
	{
		$return = [];
		
		foreach ($formContainers as $priority) {
			foreach ($priority as $formContainer) {
				$return[] = $formName . '-' . $formContainer['name'];
			}
		}

		return $return;
	}

}