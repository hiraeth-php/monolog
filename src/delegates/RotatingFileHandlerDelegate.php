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
	 * Get the instance of the class for which the delegate operates.
	 *
	 * @access public
	 * @param Hiraeth\Application $app The application instance for which the delegate operates
	 * @return object The instance of the class for which the delegate operates
	 */
	public function __invoke(Hiraeth\Application $app): object
	{
		$loggers    = $app->getConfig('*', 'logger.class', NULL);
		$collection = array_search(RotatingFileHandler::class, $loggers);
		$options    = $app->getConfig($collection, 'logger', [
			'level'    => 'Psr\Log\LogLevel::WARNING',
			'filename' => 'storage/logs/app.log',
			'maxFiles' => 5
		]);

		return new RotatingFileHandler(
			$app->getFile($options['filename'])->getPathname(),
			$options['maxFiles'],
			constant($options['level'])
		);
	}
}
