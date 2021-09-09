<?php

namespace Kenel\Di;

class Container
{
	protected $contaner;

	public function __construct()
	{
		$this->contaner = new \DI\Container();
	}

	public function get($className)
	{
		return $this->contaner->get($className);
	}

	public function set()
	{
		
	}
}