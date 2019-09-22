<?php

class EmployeesBaseControl extends BasicControl
{
	private $id;

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function render()
	{
		parent::render();
	}
}