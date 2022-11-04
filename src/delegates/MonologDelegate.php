<?php

namespace Hiraeth\Monolog;

use Hiraeth;
use Monolog\Logger;
use Monolog\Handler\NullHandler;

/**
 * {@inheritDoc}
 */
class MonologDelegate implements Hiraeth\Delegate
{
	/**
	 * Default configuration for a logger
	 *
	 * @var array<string, mixed>
	 */
	static $defaultConfig = [
		'class'    => NULL,
		'disabled' => FALSE,
		'priority' => 50,
		'options'  => [
			'level' => 'warning'
		]
	];


	/**
	 *  {@inheritDoc}
	 */
	static public function getClass(): string
	{
		return Logger::class;
	}


	/**
	 * {@inheritDoc}
	 */
	public function __invoke(Hiraeth\Application $app): object
	{
		$options = array();
		$logger  = new Logger($app->getId());

		if ($app->getEnvironment('LOGGING', 'warning')) {
			$configs = $app->getConfig('*', 'logger', static::$defaultConfig);

			usort($configs, function ($a, $b) {
				return $a['priority'] - $b['priority'];
			});

			foreach ($configs as $path => $config) {
				if (!$config['class'] || $config['disabled']) {
					continue;
				}

				foreach ($config['options'] as $key => $value) {
					$options[':' . $key] = $value;
				}

				$logger->pushHandler($app->get($config['class'], $options));
			}

		} else {
			$logger->pushHandler($app->get(NullHandler::class));
		}

		return $app->share($logger);
	}
}
