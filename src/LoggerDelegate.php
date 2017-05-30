<?php

namespace Hiraeth\Monolog;

use Hiraeth;
use Monolog;

/**
 *
 */
class LoggerDelegate implements Hiraeth\Delegate
{
	/**
	 * The Hiraeth application instance
	 *
	 * @access protected
	 * @var Hiraeth\Application
	 */
	protected $app = NULL;


	/**
	 * The Hiraeth configuration instance
	 *
	 * @access protected
	 * @var Hiraeth\Configuration
	 */
	protected $config = NULL;


	/**
	 * Get the class for which the delegate operates.
	 *
	 * @static
	 * @access public
	 * @return string The class for which the delegate operates
	 */
	static public function getClass()
	{
		return 'Monolog\Logger';
	}


	/**
	 * Get the interfaces for which the delegate provides a class.
	 *
	 * @static
	 * @access public
	 * @return array A list of interfaces for which the delegate provides a class
	 */
	static public function getInterfaces()
	{
		return [
			'Psr\Log\LoggerInterface'
		];
	}


	/**
	 * Construct the monolog delegate
	 *
	 * @access public
	 * @param Hiraeth\Application $app The Hiraeth application instance
	 * @param Hiraeth\Configuration $config The Hiraeth configuration instance
	 * @return void
	 */
	public function __construct(Hiraeth\Application $app, Hiraeth\Configuration $config)
	{
		$this->app    = $app;
		$this->config = $config;
	}


	/**
	 * Get the instance of the class for which the delegate operates.
	 *
	 * @access public
	 * @param Hiraeth\Broker $broker The dependency injector instance
	 * @return Monolog\Logger The instance of our logger
	 */
	public function __invoke(Hiraeth\Broker $broker)
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
