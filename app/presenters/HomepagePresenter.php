<?php

namespace App\Presenters;

final class HomepagePresenter extends BasePresenter
{
	protected function createComponentComponentDefault()
	{
		$component = $this->contentBoxFactory->create();
		$component->setComponent('homepageDefault', $this->container->getService('homepageDefaultControlFactory')->create());
		return $component;
	}
}
