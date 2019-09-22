<?php
use Nette\Application\UI\Control;

class BasicControl extends Control
{
	/** @var Nette\Database\Context */
	private $database;

	public $page = 1;
	public $paginator;


	public function __construct(Nette\Database\Context $database)
	{
		parent::__construct();
		$this->database = $database;
	}

	public function setComponent($name, \Nette\ComponentModel\IComponent $control)
	{
		$this->addComponent($control, $name);
	}

	function prepareComponent()
	{
		return NULL;
	}

	public function attached($parent) {
		parent::attached($parent);

		try {
			$this->prepareComponent();
		} catch (\Exception $e) {
			\Tracy\Debugger::log($e->getMessage(), \Tracy\ILogger::ERROR);
		}
	}

	public function preparePagination($total, $limit)
	{
		try {
			$this->createPaginator($total, $limit);
		} catch (\Exception $e) {
			\Tracy\Debugger::log($e->getMessage(), \Tracy\ILogger::ERROR);
			die();
		}
	}

	public function createPaginator($total, $limit)
	{
		$paginator = new Nette\Utils\Paginator;
		$paginator->setItemCount($total);
		$paginator->setItemsPerPage($limit);
		$paginator->setPage($this->page);

		$this->paginator = $paginator;
	}

	public function getPage()
	{
		$this->page;
	}

	public function handlechangePage(int $page = 1)
	{
		$this->page = $page;
	}

	function generateXMLfile($rows, $fileName, $rootNode, $childNode)
	{
		$date = new DateTime();
		$fileName = $fileName.'_export_'.$date->getTimestamp().'.xml';

		$dom = new DOMDocument('1.0', 'utf-8');
		$dom->formatOutput = true;

		$root = $dom->createElement($rootNode);

		foreach ($rows as $row) {
			$child = $dom->createElement($childNode);
			$child->setAttribute('id', $row->id);
			foreach ($row as $key => $value) {
				$el = $dom->createElement($key, $value);
				$child->appendChild($el);

			}
			$root->appendChild($child);
		}
		$dom->appendChild($root);
		$dom->save($fileName);

		$root = realpath(dirname(__FILE__) . '/../../../');
		$filePath = $root . '/temp/files/';
		$file = $filePath . $fileName;

		file_put_contents($file, $dom->saveXML());

		return $file;
	}

//	@TODO ?
//	public function createTemplate($class = NULL)
//	{
//		$template = parent::createTemplate($class);
//		return $template;
//	}

	/**
	 * @throws \Exception
	**/
	public function render()
	{
		try {
			$this->getData();
		} catch (\Exception $e) {
			\Tracy\Debugger::log($e->getMessage(), \Tracy\ILogger::ERROR);
			throw $e;
		}
	}

	public function getData()
	{
		return NULL;
	}
}