<?php

namespace Wame\DynamicObject\Forms\Containers;

use Nette;
use Nette\Forms\Container;
use Nette\Application\UI;
use Tracy\Debugger;
use Wame\DynamicObject\Forms\EntityForm;
use Wame\Utils\Latte\FindTemplate;
use Wame\Utils\Strings;

/**
 * Class BaseContainer
 *
 * @package Wame\DynamicObject\Forms\Containers
 */
abstract class BaseContainer extends Container
{
    /** @var UI\ITemplate */
    protected $template;

    /** @var UI\ITemplateFactory */
    private $templateFactory;

    /** @var string */
    private $templateFile;

    /** @var string */
    private $dir;


    /**
     * BaseContainer constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->monitor('Nette\Forms\Form');
    }


//    /**
//     * Inject TemplateFactory
//     *
//     * @param UI\ITemplateFactory $templateFactory
//     */
//    public function injectTemplateFactory(UI\ITemplateFactory $templateFactory)
//    {
//        $this->templateFactory = $templateFactory;
//    }

    /**
     * Render
     */
    public function render()
    {
        $this->template = $this->getTemplate();
        $this->template->_form = $this->getForm();
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
        if ($this->template === null) {
            $value = $this->createTemplate();

            if (!$value instanceof UI\ITemplate && $value !== null) {
                $class2 = get_class($value);
                $class = get_class($this);

                throw new Nette\UnexpectedValueException("Object returned by $class::createTemplate() must be instance of Nette\\Application\\UI\\ITemplate, '$class2' given.");
            }

            $this->template = $value;
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
        $filePath = dirname($this->getReflection()->getFileName());
        $dir = $this->dir ?: explode(DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'wame' . DIRECTORY_SEPARATOR, $filePath, 2)[1];

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
     * @param string $template
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
     * @param $dir
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
     * @param Form $form form
     * @param array $values values
     */
    public function postUpdate($form, $values)
    {

    }

    /**
     * Post create
     *
     * @param Form $form form
     * @param array $values values
     */
    public function postCreate($form, $values)
    {

    }


    /**
     * Attached
     *
     * @param $object
     */
    protected function attached($object)
    {
        parent::attached($object);

        if ($object instanceof Nette\Forms\Form) {
            $this->currentGroup = $this->getForm()->getCurrentGroup();

            // TODO: co s tymto
            if (!$this->currentGroup) {
                $object->addGroup();
            }

            $this->configure();

            $this->appendFormContainerToCurrentGroup();

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
    abstract protected function configure();


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
     * Form container processing
     *
     * @param UI\Form $form
     * @param array $values
     */
    public function formContainerSucceeded($form, $values)
    {
        if ($form instanceof EntityForm) {
            if ($form->getEntity()->getId()) {
                $this->update($form, $values);
            } else {
                $this->create($form, $values);
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
     * @param UI\Form $form form
     * @param array $values values
     */
    public function update($form, $values)
    {

    }

    /**
     * Create
     *
     * @param UI\Form $form form
     * @param array $values values
     */
    public function create($form, $values)
    {

    }

}