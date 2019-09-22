<?php

use App\Model\EmployeeModel;
use Nette\Application\AbortException;

class EmployeesDetailControl extends EmployeesBaseControl
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

	protected function createComponentEditForm()
	{
		$form = new \Nette\Application\UI\Form();
		$form->addText('first_name', 'First name')
			->setRequired(true);
		$form->addText('last_name', 'Last name')
			->setRequired(true);
		$form->addSelect('sex', 'Sex', ['male'=>'Male', 'female'=>'Female'])
			->setPrompt('- Select -')
			->setRequired(true);
		$form->addInteger('age', 'Age')
			->setDefaultValue('')
			->setRequired(true);

		$form->addSubmit('save', 'Save changes');

		$data = array(
			'first_name' => $this->employee->first_name,
			'last_name' => $this->employee->last_name,
			'sex' => $this->employee->sex,
			'age' => $this->employee->age,
		);
		$form->setDefaults($data);

		$form->onSuccess[] = [$this, 'editFormSubmitted'];
		return $form;
	}

	/**
	 * @throws \Exception
	 **/
	public function editFormSubmitted(\Nette\Application\UI\Form $form, $values)
	{
		try {
			$full_name = $values['first_name'] . ' ' . $values['last_name'];
			$this->model->updateEmployee($this->getId(), $values);
			$this->flashMessage(
				'Employee '.$full_name.' updated successfully.',
				'success'
			);
			$this->redirect('this');
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

		$this->template->setFile(__DIR__ . '/employees.detail.control.latte');
		$this->template->item = $this->employee;
		$this->template->render();
	}
}

interface IEmployeesDetailControl
{
	/**
	 * @return EmployeesDetailControl
	 */
	public function create($id);
}