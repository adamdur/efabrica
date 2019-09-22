<?php

use App\Model\EmployeeModel;
use Nette\Application\AbortException;
use \Nette\Application\UI\Form;

class EmployeesImportControl extends EmployeesBaseControl
{
	/** @var EmployeeModel */
	private $model;

	public function __construct(Nette\Database\Context $database, EmployeeModel $employeeModel)
	{
		parent::__construct($database);
		$this->model = $employeeModel;
	}

	protected function createComponentImportForm()
	{
		$form = new Form();
		$form->addUpload('file', 'File')
			->addRule(array($this,'validateFileExtension'), 'Supported file format is .xml')
			->addRule(Form::MAX_FILE_SIZE, 'Maximum file size is 5 MB.', 5 * 1024 * 1024)
			->addRule(Form::FILLED , "File is required.");

		$form->addSubmit('import', 'Import employees');

		$form->onSuccess[] = [$this, 'importFormSubmitted'];
		return $form;
	}

	/**
	 * @throws \Exception
	 **/
	public function importFormSubmitted(\Nette\Application\UI\Form $form, $values)
	{
		try {
			$this->model->importEmployeesFromXML($values->file);
			$this->flashMessage(
				'Employees imported successfully.',
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

	public function validateFileExtension(Nette\Forms\Controls\UploadControl $control)
	{
		$name = $control->getValue();
		if (!preg_match('/\.xml$/', $name->getName())) {
			return false;
		}

		return true;
	}

	public function render()
	{
		parent::render();

		$this->template->setFile(__DIR__ . '/employees.import.control.latte');
		$this->template->render();
	}
}

interface IEmployeesImportControl
{
	/**
	 * @return EmployeesImportControl
	 */
	public function create();
}