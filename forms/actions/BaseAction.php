<?php

namespace Wame\DynamicObject\Forms\Actions;

use Nette\Application\UI;
use Nette\Forms\Container;
use Nette\Forms;
use Wame\DynamicObject\Forms\BaseForm;
use Wame\DynamicObject\Forms\EntityForm;
use Wame\DynamicObject\Forms\RowForm;

abstract class BaseAction extends Container
{

    public function __construct()
    {
        parent::__construct();

        \Tracy\Debugger::barDump("BaseAction construct");

        $this->monitor(UI\Presenter::class);
        $this->monitor(Forms\Form::class);
    }


    /**
     * Post update
     *
     * @param BaseForm $form form
     * @param array $values values
     */
    public function postUpdate($form, $values) {}

    /**
     * Post create
     *
     * @param BaseForm $form form
     * @param array $values values
     */
    public function postCreate($form, $values) {}

    /**
     * Update
     *
     * @param EntityForm $form form
     * @param array $values values
     */
    public function update($form, $values) {}

    /**
     * Create
     *
     * @param EntityForm $form form
     * @param array $values values
     */
    public function create($form, $values) {}

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


    protected function attached($object)
    {
        \Tracy\Debugger::barDump("BaseAction attached");

        parent::attached($object);

        if ($object instanceof Forms\Form) {
            $this->configure();
//            $this->appendFormContainerToCurrentGroup();

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

}