<?php

namespace App\Presenters;


final class EmployeesPresenter extends BasePresenter
{
	public $id = NULL;

	public function actionDetail($id)
	{
		$this->id = $id;
	}

	public function actionDelete($id)
	{
		$this->id = $id;
	}

	protected function createComponentComponentDefault()
	{
		$component = $this->contentBoxFactory->create();
		$component->setComponent('employeesList', $this->container->getService('employeesListControlFactory')->create());
		return $component;
	}

	protected function createComponentComponentDetail()
	{
		$component = $this->contentBoxFactory->create();
		$component->setComponent('employeesDetail', $this->container->getService('employeesDetailControlFactory')->create($this->id));
		return $component;
	}

	protected function createComponentComponentCreate()
	{
		$component = $this->contentBoxFactory->create();
		$component->setComponent('employeesCreate', $this->container->getService('employeesCreateControlFactory')->create());
		return $component;
	}

	protected function createComponentComponentDelete()
	{
		$component = $this->contentBoxFactory->create();
		$component->setComponent('employeesDelete', $this->container->getService('employeesDeleteControlFactory')->create($this->id));
		return $component;
	}

	protected function createComponentComponentImport()
	{
		$component = $this->contentBoxFactory->create();
		$component->setComponent('employeesImport', $this->container->getService('employeesImportControlFactory')->create());
		return $component;
	}
}
