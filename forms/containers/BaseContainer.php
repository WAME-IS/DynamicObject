<?php

namespace Wame\DynamicObject\Forms\Containers;

use Nette;
use Nette\DI;
use Nette\Application\UI;
use Nette\Forms\Container;
use Nette\Utils\Callback;
use Nette\Forms\Controls\SubmitButton;
use Tracy\Debugger;
use Wame\Core\Traits\TRegister;
use Wame\DynamicObject\Forms\BaseForm;
use Wame\DynamicObject\Forms\EntityForm;
use Wame\DynamicObject\Forms\Groups\BaseGroup;
use Wame\DynamicObject\Forms\Groups\EmptyGroup;
use Wame\DynamicObject\Forms\RowForm;
use Wame\DynamicObject\Forms\Tabs\BaseTab;
use Wame\DynamicObject\Traits\TCurrentTab;
use Wame\Utils\Latte\FindTemplate;
use Wame\Utils\Strings;
use Wame\LanguageModule\Gettext\Dictionary;


/**
 * Class BaseContainer
 *
 * @package Wame\DynamicObject\Forms\Containers
 */
abstract class BaseContainer extends Container
{
    /** @var DI\Container */
    public $container;

    /** @var Dictionary */
    public $dictionary;

    /** @var UI\ITemplate */
    protected $template;

    /** @var UI\ITemplateFactory */
    private $templateFactory;

    /** @var string */
    private $templateFile;

    /** @var string */
    private $dir;
    
    /** @var array */
	private $httpPost;

    /** @var \Closure */
    private $callback;


    use TRegister;
    use TCurrentTab;


    /**
     * BaseContainer constructor.
     *
     * @param DI\Container $container
     */
    public function __construct(DI\Container $container)
    {
        parent::__construct();

        $this->monitor(UI\Presenter::class);
        $this->monitor(Nette\Forms\Form::class);

        $this->container = $container;
        $container->callInjects($this);
    }


    /**
     * Inject dictionary
     *
     * @param Dictionary $dictionary
     */
    public function injectDictionary(Dictionary $dictionary)
    {
        $this->dictionary = $dictionary;
    }


    /**
     * Render
     */
    public function render()
    {
        $form = $this->getForm();

        $this->template = $this->getTemplate();
//        $this->template->_control = $this->linkGenerator;
        $this->template->_form = $this->getForm();
        $this->template->getLatte()->addProvider('formsStack', [$form]);
        $this->template->container = $form[$this->getName()];
        $this->compose($this->template);
        $this->template->render($this->getTemplateFile());
    }


    /**
     * Bind data to the template
     *
     * @param $template
     */
    public function compose($template)
    {

    }


    /**
     * Get template
     *
     * https://api.nette.org/2.3.7/source-Application.UI.Control.php.html#45
     *
     * @return UI\ITemplate|UI\ITemplateFactory
     */
    public function getTemplate()
    {
        $this->dictionary->setDomain($this);

        if ($this->template === null) {
            $value = $this->createTemplate();

            if (!$value instanceof UI\ITemplate && $value !== null) {
                $class2 = get_class($value);
                $class = get_class($this);

                throw new Nette\UnexpectedValueException("Object returned by $class::createTemplate() must be instance of Nette\\Application\\UI\\ITemplate, '$class2' given.");
            }

            $this->template = $value;

            $this->template->getLatte()->addProvider('uiControl', $this);
            $this->template->getLatte()->addProvider('uiForm', $this->getForm());
            $this->template->getLatte()->addProvider('uiPresenter', $this->getPresenter());
        }

        return $this->template;
    }


    /**
     * Get template file path
     *
     * @return string
     * @throws \Exception
     */
    public function getTemplateFile()
    {
        $filePath = Strings::getClassPath($this);
        $dir = explode(DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'wame' . DIRECTORY_SEPARATOR, $filePath, 2)[1];

        $findTemplate = new FindTemplate($dir, $this->templateFile);
        $file = $findTemplate->find();

        if (!$file) {
            throw new \Exception(sprintf(_('Template %s %s can not be found in %s.'), $this->templateFile, FindTemplate::DEFAULT_TEMPLATE, $dir));
        }

        return $file;
    }


    /**
     * Set form container template file
     *
     * @param string $template template
     * @return $this
     */
    public function setTemplateFile($template)
    {
        $this->templateFile = $template;

        return $this;
    }


    /**
     * Set directory
     *
     * @param string $dir directory
     * @return $this
     */
    public function setDir($dir)
    {
        $this->dir = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $dir);

        return $this;
    }


    /**
     * Post update
     *
     * @param BaseForm $form form
     * @param array $values values
     */
    public function postUpdate($form, $values)
    {

    }


    /**
     * Post create
     *
     * @param BaseForm $form form
     * @param array $values values
     */
    public function postCreate($form, $values)
    {

    }


    /**
     * Form container processing
     *
     * @param UI\Form $form
     * @param array $values
     */
    public function formContainerSucceeded($form, $values)
    {
        // TODO: zjednotit pod nejaky DBForm/DoctrineForm s tym, ze aj update/create vyvolavat tu, to cele je ekoli mnohym entitam

        if ($form instanceof EntityForm) {
            if ($form->getEntity()->getId()) {
                $this->update($form, $values);
            } else {
                $this->create($form, $values);
            }
        } else if ($form instanceof RowForm) {
            $entity = $this->update($form, $values);

            if($entity) {
                if($entity->getId()) { // update
                    $form->getRepository()->update($entity);
                } else { // create
                    $form->getRepository()->create($entity);
                }
            }
        }
    }


    /**
     * Form container processing
     *
     * @param UI\Form $form
     * @param array $values
     */
    public function formContainerPostSucceeded($form, $values)
    {
        if ($form instanceof EntityForm) {
            if ($form->getEntity()->getId()) {
                $this->postUpdate($form, $values);
            } else {
                $this->postCreate($form, $values);
            }
        }
    }


    /**
     * Update
     *
     * @param EntityForm $form form
     * @param array $values values
     */
    public function update($form, $values)
    {

    }


    /**
     * Create
     *
     * @param EntityForm $form form
     * @param array $values values
     */
    public function create($form, $values)
    {

    }


    public function getPresenter()
    {
        return $this->lookup(UI\Presenter::class);
    }


    /**
     * Attached
     *
     * @param $object
     */
    protected function attached($object)
    {
        parent::attached($object);

        $this->setDictionary();

        if ($object instanceof Nette\Forms\Form) {
            if($this instanceof BaseGroup) {
                $this->configure();
            } else if($this instanceof BaseTab) {
                // tab
            } else {
                $this->currentGroup = $this->getForm()->getCurrentGroup();

                if (!$this->currentGroup) {
                    $object->addBaseGroup(new EmptyGroup);
                }

//                $this->currentGroup = $this->getForm()->getCurrentGroup() ?: $object->addBaseGroup(new BasicGroup);
                $this->currentTab = $this->getForm()->getCurrentTab();// ?: $object->addBaseTab(new GeneralTab);

//                if(method_exists($this, 'setDefaultValues')) {
//                    $this->setDefaultValues();
//                }

                $this->configure();

                $this->appendFormContainerToCurrentGroup();
            }

            if ($object instanceof UI\Form) {
                // success
                $object->onSuccess[] = function ($form) {
                    $this->formContainerSucceeded($form, $this->getValues());
                };

                // post success
                $object->onPostSuccess[] = function ($form) {
                    $this->formContainerPostSucceeded($form, $this->getValues());
                };
            }
        }
        
        if($object instanceof UI\Presenter) {
            $this->loadHttpData();
        }
    }


    /**
     * Create template
     *
     * @return UI\ITemplate
     */
    protected function createTemplate()
    {
        /** @var UI\ITemplateFactory $templateFactory */
        $templateFactory = $this->templateFactory ?: $this->lookup(UI\Presenter::class)->getTemplateFactory();

        return $templateFactory->createTemplate(null);
    }


    /**
     * Configure
     */
    protected function configure() {

    }


    /**
     * Append form container to current group
     *
     * @return $this
     */
    private function appendFormContainerToCurrentGroup()
    {
        $this->currentGroup = $this->getForm()->getCurrentGroup();

        if ($this->currentGroup) {
            $formContainerName = Strings::getClassName($this);

            if ($this->currentGroup->getOption('formContainers')) {
                $formGroups = $this->currentGroup->getOption('formContainers');

                $formGroups[] = $formContainerName;
            } else {
                $formGroups = [$formContainerName];
            }

            $this->currentGroup->setOption('formContainers', $formGroups);
        }

        return $this;
    }


    /**
     * Set language dictionary
     */
    private function setDictionary()
    {
        $this->dictionary->setDomain($this);
    }


    /**
     * Create one
     *
     * @param string $name name
     * @return Nette\ComponentModel\IComponent
     * @internal param Container $container container
     */
    public function createOne(string $name = null)
    {
        if($name === null) {
            $names = array_keys(iterator_to_array($this->getComponents()));
			$name = $names ? max($names) + 1 : 0;
        }

        $container = null;

        if(isset($this[$name])) {
            $container = $this[$name];

        } else {
            $container = $this->addContainer($name);


        }

        return $container;
    }
    
    
    /**
	 * Loads data received from POST
     * 
	 * @internal
	 */
    protected function loadHttpData()
    {
        if(!$this->getForm()->isSubmitted()) {
            return;
        }

        foreach ((array) $this->getHttpData() as $name => $value) {
            if(is_array($value) || $value instanceof \Traversable) {
                $count = iterator_count($this->getComponents());
                $container = $this->addContainer($count);
                Callback::invoke($this->callback, $container, $this);
                Debugger::barDump($container, "loadHttpData");
            }
        }
    }

    
    /**
	 * @return mixed|NULL
	 */
	protected function getHttpData()
	{
		if ($this->httpPost === NULL) {
			$path = explode(self::NAME_SEPARATOR, $this->lookupPath('Nette\Forms\Form'));
			$this->httpPost = Nette\Utils\Arrays::get($this->getForm()->getHttpData(), $path, NULL);
		}

		return $this->httpPost;
	}


    /**
     * Add dynamic
     *
     * @param string $name
     * @param \Closure $callback
     * @return Nette\ComponentModel\IComponent|Container
     */
    public function addDynamic(string $name, \Closure $callback)
    {
        $this->callback = $callback;

        $container = isset($this[$name]) ? $this[$name] : $this->addContainer($name);

        $button = $container->addSubmit('add', _('Add'));
        
        $button->onClick[] = function(SubmitButton $button) use($callback, $container) {
            $count = iterator_count($container->getComponents());

            $newContainer = $container->addContainer($count - 1);

            if (is_callable($callback)) {
                Debugger::barDump($newContainer, "addDynamic");
                Callback::invoke($callback, $newContainer, $container);
            }
            
            $button->getForm()->onSuccess = [];
            $button->getForm()->onPostSuccess = [];
        };

        return $container;
    }
    
}
