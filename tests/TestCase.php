<?php

namespace Galahad\LaravelAddressing\Tests;

use Galahad\LaravelAddressing\Facades\Addressing;
use Galahad\LaravelAddressing\ServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
	protected function setUp() : void
	{
		parent::setUp();
		
		$config = $this->app['config'];
		
		// Add encryption key for HTTP tests
		$config->set('app.key', 'base64:tfsezwCu4ZRixRLA/+yL/qoouX++Q3lPAPOAbtnBCG8=');
		
		// Add feature stubs to view
		// $this->app['view']->addLocation(__DIR__.'/Feature/stubs');
	}
	
	protected function getPackageProviders($app) : array
	{
		return [
			ServiceProvider::class,
		];
	}
	
	protected function getPackageAliases($app) : array
	{
		return [
			'Addressing' => Addressing::class,
		];
	}
}
