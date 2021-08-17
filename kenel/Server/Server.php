<?php

namespace Kenel\Server;

use Swoole\Http\Server as SwooleHttpServer;

class Server
{
	protected $server;

	public function init($config)
    {
        $servers = $config['servers'];

        foreach ($servers as $server) {
            $name = $server['name'];
            $type = $server['type'];
            $host = $server['host'];
            $port = $server['port'];
            $sockType = $server['sock_type'];
            $callbacks = $server['callbacks'];

            $this->server = new SwooleHttpServer($host, $port, $config['mode'], $sockType);
            $this->registerSwooleEvents($this->server, $callbacks, $name);
            $this->server->set($config['settings']);
            return;
            //ServerManager::add($name, [$type, current($this->server->ports)]);

           
        }
    }

    public function start()
    {
        $this->server->start();
    }

    protected function registerSwooleEvents($server, array $events, string $serverName)
    {
        foreach ($events as $event => $callback) {
            if (is_array($callback)) {
                [$className, $method] = $callback;
                $container = new \DI\Container();
                $class = $container->get($className);
                // if ($class instanceof MiddlewareInitializerInterface) {
                //     $class->initCoreMiddleware($serverName);
                // }
                $callback = [$class, $method];
            }
            $server->on($event, $callback);
        }
    }
}