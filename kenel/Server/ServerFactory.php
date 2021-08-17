<?php

namespace Kenel\Server;

class ServerFactory
{
	protected $config;

	protected $server;

	public function configure($config)
	{
		$this->config = $config;
		$this->getServer()->init($this->config);
	}

	public function start()
    {
        return $this->getServer()->start();
    }

	public function getServer()
    {   
    	if(empty($this->server)){
    		$this->server = new Server();
    	}
        
        return $this->server;
    }
}