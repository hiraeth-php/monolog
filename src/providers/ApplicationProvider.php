<?php

namespace Hiraeth\Monolog;

use Hiraeth;
use Monolog\Logger;

/**
 * {@inheritDoc}
 */
class ApplicationProvider implements Hiraeth\Provider
{
	/**
	 * {@inheritDoc}
	 */
	static public function getInterfaces(): array
	{
		return [
			Hiraeth\Application::class
		];
	}


	/**
	 * {@inheritDoc}
	 */
	public function __invoke($instance, Hiraeth\Application $app): object
	{
		if ($app->getEnvironment('LOGGING', 'warning')) {
			$app->setLogger(Logger::class);
		}

		return $instance;
	}
}
