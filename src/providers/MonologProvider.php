<?php

namespace Hiraeth\Monolog;

use Hiraeth;
use Monolog\Logger;
use Psr\Log\LoggerAwareInterface;

/**
 *
 */
class MonologProvider implements Hiraeth\Provider
{
	/**
	 * Get the interfaces for which the provider operates.
	 *
	 * @access public
	 * @return array A list of interfaces for which the provider operates
	 */
	static public function getInterfaces(): array
	{
		return [
			LoggerAwareInterface::class
		];
	}


	/**
	 * Prepare the instance.
	 *
	 * @access public
	 * @var object $instance The unprepared instance of the object
	 * @param Application $app The application instance for which the provider operates
	 * @return object The prepared instance
	 */
	public function __invoke($instance, Hiraeth\Application $app): object
	{
		$instance->setLogger($app->get(Logger::class));

		return $instance;
	}
}
