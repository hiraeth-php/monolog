<?php

namespace Hiraeth\Monolog;

use Hiraeth;
use Psr\Log\LogLevel;
use Monolog\Handler\RotatingFileHandler;

/**
 *
 */
class RotatingFileHandlerDelegate implements Hiraeth\Delegate
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
		return RotatingFileHandler::class;
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
		$loggers    = $this->app->getConfig('*', 'logger.class', NULL);
		$collection = array_search(RotatingFileHandler::class, $loggers);
		$options    = $this->app->getConfig($collection, 'logger', [
			'level'    => 'Psr\Log\LogLevel::WARNING',
			'filename' => 'storage/logs/app.log',
			'maxFiles' => 5
		]);

		return new RotatingFileHandler(
			$this->app->getFile($options['filename'])->getPathname(),
			$options['maxFiles'],
			constant($options['level'])
		);
	}
}
