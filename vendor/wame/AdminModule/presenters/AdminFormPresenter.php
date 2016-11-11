<?php

namespace Wame\DynamicObject\Vendor\Wame\AdminModule\Presenters;

use App\AdminModule\Presenters\BasePresenter;
use Wame\PermissionModule\Models\PermissionObject;

abstract class AdminFormPresenter extends BasePresenter
{
    /** @var BaseRepository */
    public $repository;
    
    /** @var BaseEntity */
    protected $entity;

    /** @var int */
    protected $count;
    
    /** @var PermissionObject @inject */
    public $permissionObject;
    
    
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
    
    
    /** methods ***************************************************************/
    
    protected function getEntityById()
    {
        return $this->repository->get(['id' => $this->id]);
    }


    /** abstract methods ******************************************************/

    /**
     * Get form builder service alias
     *
     * @return string
     */
	abstract protected function getFormBuilderServiceAlias();

}
