<?php

namespace Wame\DynamicObject\Vendor\Wame\AdminModule\Presenters;

use App\AdminModule\Presenters\BasePresenter;


abstract class AdminFormPresenter extends BasePresenter
{
    /** @var BaseRepository */
    public $repository;

    /** @var BaseEntity */
    protected $entity;

    /** @var int */
    protected $count;


    /** actions ***************************************************************/

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
        $this->entity = $this->repository->get(['id' => $this->id]);
    }


    /**
     * Action edit
     */
    public function actionEdit()
	{
        $this->entity = $this->repository->get(['id' => $this->id]);
	}


    /** components ************************************************************/

    /**
	 * Create component form
	 *
	 * @return BaseForm	form
	 */
	protected function createComponentForm()
	{
		return $this->context
                    ->getService($this->getFormBuilderServiceAlias())
                    ->setEntity($this->entity)
                    ->build($this->id);
	}


    /**
     * Create component grid
     *
     * @return DataGridControl
     */
    protected function createComponentGrid()
    {
        if (!$this->repository && $this->getGridServiceAlias()) {
            throw new \Exception("Repository or grid service alias not initialized in presenter");
        }

        $grid = $this->context->getService($this->getGridServiceAlias());

        $qb = $this->repository->createQueryBuilder();
		$grid->setDataSource($qb);

        return $grid;
    }


    /** abstract methods ******************************************************/

    /**
     * Get form builder service alias
     *
     * @return string
     */
	abstract protected function getFormBuilderServiceAlias();

}
