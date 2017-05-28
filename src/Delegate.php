<?php

namespace Hiraeth\Monolog;

use Auryn;
use Hiraeth;
use Monolog;

/**
 *
 */
class Delegate implements Hiraeth\Delegate
{
	/**
	 *
	 */
	protected $app = NULL;


	/**
	 *
	 */
	protected $config = NULL;


	/**
	 *
	 */
	public function __construct(Hiraeth\Application $app, Hiraeth\Configuration $config)
	{
		$this->app    = $app;
		$this->config = $config;
	}


	/**
	 *
	 */
	static public function getClass()
	{
		return 'Monolog\Logger';
	}


	/**
	 *
	 */
	static public function getInterfaces()
	{
		return [
			'Psr\Log\LoggerInterface'
		];
	}


	/**
	 *
	 */
	public function __invoke(Auryn\Injector $broker)
	{
		$logger   = new Monolog\Logger('app');
		$handlers = $this->config->get('monolog', 'handlers', array());

		if (isset($handlers['file'])) {
			$logger->pushHandler(new Monolog\Handler\RotatingFileHandler(
				$this->app->getFile($handlers['file'])
			));
		}

		$broker->share($logger);

		return $logger;
	}
}
