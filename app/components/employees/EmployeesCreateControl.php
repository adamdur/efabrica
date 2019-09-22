<?php

use App\Model\EmployeeModel;
use Nette\Application\AbortException;
use \Nette\Application\UI\Form;

class EmployeesCreateControl extends EmployeesBaseControl
{
	/** @var EmployeeModel */
	private $model;

	public function __construct(Nette\Database\Context $database, EmployeeModel $employeeModel)
	{
		parent::__construct($database);
		$this->model = $employeeModel;
	}

	protected function createComponentCreateForm()
	{
		$form = new Form();
		$form->addText('first_name', 'First name')
			->setDefaultValue('')
			->setRequired(true);
		$form->addText('last_name', 'Last name')
			->setDefaultValue('')
			->setRequired(true);
		$form->addSelect('sex', 'Sex', ['male'=>'Male', 'female'=>'Female'])
			->setPrompt('- Select -')
			->setRequired(true);
		$form->addInteger('age', 'Age')
			->setDefaultValue('')
			->setRequired(true);

		$form->addSubmit('create', 'Create employee');

		$form->onSuccess[] = [$this, 'createFormSubmitted'];
		return $form;
	}

	/**
	 * @throws \Exception
	**/
	public function createFormSubmitted(\Nette\Application\UI\Form $form, $values)
	{
		try {
			$full_name = $values['first_name'] . ' ' . $values['last_name'];
			$this->model->createEmployee($values);
			$this->flashMessage(
				'Employee '.$full_name.' created successfully.',
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

		$this->template->setFile(__DIR__ . '/employees.create.control.latte');
		$this->template->render();
	}
}

interface IEmployeesCreateControl
{
	/**
	 * @return EmployeesCreateControl
	 */
	public function create();
}