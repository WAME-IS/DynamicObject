<?php

namespace Wame\DynamicObject\Vendor\Wame\AdminModule\Presenters;

use App\AdminModule\Presenters\BasePresenter;
use Wame\Core\Entities\BaseEntity;
use Wame\Core\Repositories\BaseRepository;
use Wame\DataGridControl\DataGridControl;
use Wame\DynamicObject\Forms\BaseForm;
use Wame\PermissionModule\Models\PermissionObject;


abstract class AdminFormPresenter extends BasePresenter
{
    /** @var PermissionObject @inject */
    public $permissionObject;

    /** @var BaseRepository */
    public $repository;

    /** @var BaseEntity */
    protected $entity;

    /** @var int */
    protected $count;

    /** @var array */
    protected $formContainers = [];

    /** @var array */
    protected $detachformContainers = [];


    /** execution *************************************************************/

    /**
     * Action default
     */
    public function actionDefault()
    {
        $this->count = $this->repository->countBy();
    }


    /**
     * Action show
     */
    public function actionShow()
    {
        $this->entity = $this->getEntityById();
    }


    /**
     * Action edit
     */
    public function actionEdit()
	{
        $this->entity = $this->getEntityById();
	}


    /**
     * Action delete
     */
    public function actionDelete()
	{
        $this->entity = $this->getEntityById();
	}


    /** interaction ***********************************************************/



    /** rendering *************************************************************/



    /** components ************************************************************/

    /**
	 * Create component form
	 *
	 * @return BaseForm	form
	 */
	protected function createComponentForm()
	{
		$form = $this->context
                    ->getService($this->getFormBuilderServiceAlias())
                    ->setEntity($this->entity);

		if (count($this->formContainers) > 0) {
		    foreach ($this->formContainers as $container) {
		        $form->add($container['service'], $container['name'], $container['priority']);
            }
        }

        if (count($this->detachformContainers) > 0) {
            foreach ($this->detachformContainers as $container) {
                $form->remove($container);
            }
        }

        return $form->build($this->id);
	}


    /**
     * Grid component
     *
     * @return DataGridControl
     * @throws \Exception
     */
    protected function createComponentGrid()
    {
        if (!$this->repository && $this->getGridServiceAlias()) {
            throw new \Exception("Repository or grid service alias not initialized in presenter");
        }

        /** @var DataGridControl $grid */
        $grid = $this->context->getService($this->getGridServiceAlias());

        $qb = $this->repository->createQueryBuilder();
		$grid->setDataSource($qb);

        return $grid;
    }


    /** methods ***************************************************************/

    /**
     * Get entity by ID
     *
     * @return \Wame\Core\Entities\BaseEntity
     */
    protected function getEntityById()
    {
        return $this->repository->get(['id' => $this->id]);
    }


    /**
     * Get grid service alias
     *
     * @return null|string
     */
    protected function getGridServiceAlias()
    {
        return null;
    }


    /**
     * Attach form container
     *
     * @param object $service
     * @param string $name
     * @param int $priority
     *
     * @return $this
     */
    protected function attachFormContainer($service, $name, $priority = 0)
    {
        $this->formContainers[] = [
            'service' => $service,
            'name' => $name,
            'priority' => $priority
        ];

        return $this;
    }


    /**
     * Detached form container
     *
     * @param object|string $service
     *
     * @return $this
     */
    protected function detachFormContainer($service)
    {
        $this->detachformContainers[] = $service;

        return $this;
    }


    /** abstract methods ******************************************************/

    /**
     * Get form builder service alias
     *
     * @return string
     */
	abstract protected function getFormBuilderServiceAlias();

}
