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
		$options = $this->app->getConfig('loggers/rotating_file', 'logger', [
			'level'    => 'Psr\Log\LogLevel::WARNING',
			'filename' => $this->app->getFile('storage/logs/app.log')->getPathname(),
			'maxFiles' => 5
		]);

		return new RotatingFileHandler(
			$options['filename']
			$options['maxFiles'],
			constant($options['level'])
		);
	}
}
