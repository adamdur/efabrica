<?php
use App\Model\EmployeeModel;
use Nette\Application\AbortException;
use Nette\Application\Responses\FileResponse;

class EmployeesListControl extends EmployeesBaseControl
{
	/** @var EmployeeModel */
	private $model;

	private $rows;

	public function __construct(Nette\Database\Context $database, EmployeeModel $employeeModel)
	{
		parent::__construct($database);
		$this->model = $employeeModel;
	}

	private $columns = array(
		'id' => '#ID',
		'first_name' => 'First name',
		'last_name' => 'Last name',
		'sex' => 'Sex',
		'age' => 'Age'
	);

	private function getColumns() {
		return $this->columns;
	}

	public function getData()
	{
		$this->rows = $this->model->getPaginatedEmployees(10, $this->page);
	}

	public function getFullEmployees()
	{
		return $this->model->getFullEmployees();
	}

	/**
	 * @throws \Exception
	 **/
	public function handleExportXML()
	{
		$file = $this->generateXMLfile(
			$this->getFullEmployees(),
			'employees',
			'employees',
			'employee'
		);
		try {
			$this->getPresenter()->sendResponse(
				new FileResponse(
					$file,
					'export.xml',
					'text/xml',
					true
				)
			);
		} catch (\Exception $e) {
			if ($e instanceof AbortException) {
				throw $e;
			}
			\Tracy\Debugger::barDump($e, 'Exception');
			$this->flashMessage(
				'Failed to export XML. Try again.',
				'error');
		}
	}

	public function render()
	{
		parent::render();

		$this->preparePagination($this->model->getCountEmployees(), 10);
		$this->template->setFile(__DIR__ . '/employees.list.control.latte');
		$this->template->columns = $this->getColumns();
		$this->template->rows = $this->rows;
		$this->template->paginator = $this->paginator;
		$this->template->render();
	}
}

interface IEmployeesListControl
{
	/**
	 * @return EmployeesListControl
	 */
	public function create();
}