<?php

namespace Hiraeth\Monolog;

use Hiraeth;
use Monolog\Logger;
use Psr\Log\LoggerAwareInterface;

/**
 * {@inheritDoc}
 */
class MonologProvider implements Hiraeth\Provider
{
	/**
	 * {@inheritDoc}
	 */
	static public function getInterfaces(): array
	{
		return [
			LoggerAwareInterface::class
		];
	}


	/**
	 * {@inheritDoc}
	 */
	public function __invoke($instance, Hiraeth\Application $app): object
	{
		$instance->setLogger($app->get(Logger::class));

		return $instance;
	}
}
