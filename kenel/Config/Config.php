<?php
namespace Kenel\Config;

class Config
{
	protected $config;

	public function __construct($config)
	{
		$this->config = $config;
	}

	public function get($key)
	{
		$keyArr = explode('.', $key);
		$val = $this->config;
		foreach ($keyArr as $v) {
			$val = $val[$v];
		}
		return $val;
	}
}