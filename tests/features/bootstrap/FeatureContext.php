<?php

use Behat\MinkExtension\Context\RawMinkContext;
use Cjm\Behat\Psr7Extension\ServiceContainer\AppAwareInterface;
use Cjm\Behat\Psr7Extension\CachingLoader;

class FeatureContext extends RawMinkContext implements AppAwareInterface
{
	/**
	 * @var CachingLoader
	 */
	protected $_loader;

	public function setCachingLoader(CachingLoader $loader)
	{
		$this->_loader = $loader;
	}
}
