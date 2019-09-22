<?php

use App\Model\EmployeeModel;

class HomepageDefaultControl extends HomepageBaseControl
{
	/** @var EmployeeModel */
	private $model;

	private $employees;

	public function __construct(Nette\Database\Context $database, EmployeeModel $employeeModel)
	{
		parent::__construct($database);
		$this->model = $employeeModel;
	}

	public function prepareComponent()
	{
		$this->employees = $this->model->getFullEmployees();
	}

	public function prepareGraphData()
	{
		$years = [];
		foreach ($this->employees as $row) {
			array_push($years, $row->age);
		}
		return implode(',', $years);
	}

	public function render()
	{
		parent::render();

		$this->template->setFile(__DIR__ . '/homepage.default.control.latte');
		$this->template->years = $this->prepareGraphData();
		$this->template->render();
	}
}

interface IHomepageDefaultControl
{
	/**
	 * @return HomepageDefaultControl
	 */
	public function create();
}