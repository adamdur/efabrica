<?php

use App\Model\EmployeeModel;
use Nette\Application\AbortException;

class EmployeesDeleteControl extends EmployeesBaseControl
{
	/** @var EmployeeModel */
	private $model;

	private $employee;

	public function __construct($id, Nette\Database\Context $database, EmployeeModel $employeeModel)
	{
		parent::__construct($database);
		$this->model = $employeeModel;
		$this->setId($id);
	}

	public function prepareComponent()
	{
		if ($this->getId())
		{
			$this->employee = $this->model->getEmployeeById($this->getId());
		}
	}

	protected function createComponentDeleteForm()
	{
		$form = new \Nette\Application\UI\Form();

		$form->addSubmit('delete', 'Delete employee');

		$form->onSuccess[] = [$this, 'editFormSubmitted'];
		return $form;
	}

	/**
	 * @throws \Exception
	 **/
	public function editFormSubmitted(\Nette\Application\UI\Form $form, $values)
	{
		try {
			$full_name = $this->employee->first_name . ' ' . $this->employee->last_name;
			$this->model->deleteEmployee($this->getId());
			$this->flashMessage(
				'Employee '.$full_name.' deleted.',
				'success'
			);
			$this->getPresenter()->redirect("Employees:default");
		} catch (\Exception $e) {
			if ($e instanceof AbortException) {
				throw $e;
			}
			\Tracy\Debugger::barDump($e, 'Exception');
			$form->addError($e->getMessage());
		}
	}

	public function render()
	{
		parent::render();

		$this->template->setFile(__DIR__ . '/employees.delete.control.latte');
		$this->template->item = $this->employee;
		$this->template->render();
	}
}

interface IEmployeesDeleteControl
{
	/**
	 * @return EmployeesDeleteControl
	 */
	public function create($id);
}