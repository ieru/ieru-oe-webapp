<?php
/**
 * Entry point to the REST API engine
 *
 * @package     Organic.Edunet API
 * @version     1.0 - 2013-04-04
 * 
 * @author      David Baños Expósito
 * @copyright   Copyright (c)2013
 */

	// Error control, remove in production
	error_reporting( E_ALL );
	ini_set( 'display_errors', '1' );

	// Autoload files with the Symfony autoloader, according to PSR-0
	require_once( 'vendor/Symfony/Component/ClassLoader.php' );
	$loader = new \Symfony\Component\ClassLoader\ClassLoader();

	// register classes with namespaces
	$loader->addPrefix( 'Ieru\\', __DIR__.'/ieru' );
	$loader->register();
	$loader->setUseIncludePath(true);

	// Start ieru restengine, with api URI identifier and API URI namespace
	$api = new \Ieru\Restengine\Engine\Engine( 'api', 'Ieru\Ieruapis' );
	$api->start();