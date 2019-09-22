<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


class BasePresenter extends Nette\Application\UI\Presenter
{
	/** @var \IContentBox @inject */
	public $contentBoxFactory;

	/** @var Nette\DI\Container @inject */
	public $container;

	protected function startup()
	{
		parent::startup();
	}

	public function preparePagination($data): void
	{
		if ( !isset($data->total) ||
			 !isset($data->offset) ||
			 !isset($data->limit)
		) {
			$this->template->pagination = false;
			return;
		}
		$this->template->pagination = true;
		$this->template->page = $data->offset;
		$this->template->lastPage = ceil($data->total / $data->limit );
	}
}
