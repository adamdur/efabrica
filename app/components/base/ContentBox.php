<?php
use Nette\Application\UI\Control;
use Nette\ComponentModel\IComponent;

class ContentBox extends Control
{
	private $component;

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param  mixed
	 * @param  IComponent
	 */
	public function setComponent($name, \Nette\ComponentModel\IComponent $control)
	{
		$this->component = $name;
		$this->addComponent($control, $name);
	}

	public function render()
	{
		$this->template->component = $this->component;
		$this->template->setFile(__DIR__ . '/box.latte');
		$this->template->render();
	}
}

interface IContentBox
{
	/**
	 * @return ContentBox
	 */
	public function create();
}