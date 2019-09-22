<?php

namespace App\Model;

use Nette;

class EmployeeModel
{
	use Nette\SmartObject;

	/** @var Nette\Database\Context */
	private $database;

	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}

	public function getCountEmployees()
	{
		return $this->database->table('employees')
			->count('*');
	}

	public function getFullEmployees()
	{
		return $this->database->table('employees')
			->order('id ASC')->fetchAll();
	}

	public function getPaginatedEmployees($limit = 10, $page = 1)
	{
		$rows = $this->database->table('employees')
			->order('id ASC')
			->limit($limit, ($page - 1) * $limit )
			->fetchAll();

		return $rows;
	}

	public function getEmployeeById($id)
	{
		return $this->database->table('employees')
			->where('id', $id)
			->fetch();
	}

	public function updateEmployee($id, $data)
	{
		$this->database->table('employees')
			->where('id', $id)
			->update($data);
	}

	public function createEmployee($data)
	{
		$this->database->table('employees')
			->insert($data);
	}

	public function deleteEmployee($id)
	{
		$this->database->table('employees')
			->where('id', $id)
			->delete();
	}

	public function importEmployeesFromXML($xml) {
		$xmldata = simplexml_load_string($xml->getContents()) or die("Failed to load");
		$data = [];
		foreach($xmldata->children() as $employee) {
			array_push($data, [
				'first_name' => (string) $employee->first_name,
				'last_name' => (string) $employee->last_name,
				'sex' => (string) $employee->sex,
				'age' => (int) $employee->age,
			]);
		}
		$this->database->table('employees')
			->insert($data);
	}
}