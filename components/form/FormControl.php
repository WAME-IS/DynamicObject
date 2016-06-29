<?php 

namespace Wame\DynamicObject\Components;

use Nette\DI\Container;
use Nette\Utils\Html;
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
	/** @var mixed */
	protected $form;

	/** @var string */
	private $formName;

	/** @var int */
	public $id;


	public function __construct(
		$formName,
		Container $container,
		HttpRequest $httpRequest
	) {
		parent::__construct();

		$this->formName = $formName;
		$this->id = $httpRequest->getParameter('id');

		$this->form = $container->getService(Strings::firstUpper($formName));
		$this->addComponent($this->form->setId($this->id)->build(), $formName);
	}


	public function render()
	{		
		$this->template->formName = $this->formName;
		$this->template->formGroups = $this->getComponent($this->formName)->getGroups();
		$this->template->formContainers = $this->getFormContainers($this->form->sortFormContainers(), $this->formName);
		$this->template->defaultContainer = Html::el('fieldset');

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