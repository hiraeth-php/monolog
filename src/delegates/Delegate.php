<?php

namespace Hiraeth\Monolog;

use Hiraeth;
use Monolog\Logger;

/**
 *
 */
class Delegate implements Hiraeth\Delegate
{
	/**
	 * Get the class for which the delegate operates.
	 *
	 * @static
	 * @access public
	 * @return string The class for which the delegate operates
	 */
	static public function getClass(): string
	{
		return Logger::class;
	}


	/**
	 *
	 */
	public function __construct(Hiraeth\Application $app)
	{
		$this->app = $app;
	}


	/**
	 * Get the instance of the class for which the delegate operates.
	 *
	 * @access public
	 * @param Hiraeth\Broker $broker The dependency injector instance
	 * @return object The instance of the class for which the delegate operates
	 */
	public function __invoke(Hiraeth\Broker $broker): object
	{
		$logger = new Logger($this->app->getId());

		foreach ($this->app->getConfig('*', 'logger', []) as $config) {
			if (!$config || $config['disabled'] ?? TRUE) {
				continue;
			}

			$logger->pushHandler($broker->make($config['class']));
		}

		return $logger;
	}
}
