<?php

namespace Hiraeth\Monolog;

use Hiraeth;
use Monolog\Logger;

/**
 *
 */
class MonologDelegate implements Hiraeth\Delegate
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
	 * Get the instance of the class for which the delegate operates.
	 *
	 * @access public
	 * @param Hiraeth\Application $app The application instance for which the delegate operates
	 * @return object The instance of the class for which the delegate operates
	 */
	public function __invoke(Hiraeth\Application $app): object
	{
		$logger = new Logger($app->getId());

		foreach ($app->getConfig('*', 'logger', []) as $config) {
			if (!$config || $config['disabled'] ?? TRUE) {
				continue;
			}

			$logger->pushHandler($app->get($config['class']));
		}

		return $logger;
	}
}
