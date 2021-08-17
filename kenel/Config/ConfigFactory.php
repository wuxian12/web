<?php
namespace Kenel\Config;
use Symfony\Component\Finder\Finder;

class ConfigFactory
{
	public function __invoke()
	{
		$configPath = BASE_PATH . '/config/';
        $config = $this->readConfig($configPath . 'config.php');
        $autoloadConfig = $this->readPaths([BASE_PATH . '/config/autoload']);
        return new Config(array_merge_recursive($config,$autoloadConfig));
	}

	public function readConfig($configPath)
	{
		$config = [];
		if(file_exists($configPath) && is_readable($configPath)){
			$config = require $configPath;
		}
		return is_array($config) ? $config : [];
	}

	public function readPaths($dirs)
	{
		$finder = new Finder();
		$finder->files()->in($dirs)->name('*.php');
		$configs = [];
		foreach ($finder as $file) {
			$configs = [
                $file->getBasename('.php') => require $file->getRealPath(),
            ];
		}
		return $configs;
	}
}