<?php
namespace Kenel\HttpServer;

class HttpServer
{
	
    protected $middlewares;

    
    protected $coreMiddleware;

    protected $dispatcher;

	public function onRequest($request, $response)
	{
		$this->initRouter();
		$httpMethod = $request->server['request_method'];
		$uri = $request->server['request_uri'];

		$routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);
		switch ($routeInfo[0]) {
		    case \FastRoute\Dispatcher::NOT_FOUND:
		    	$response->status(404);
		        $response->end('not find');
		        break;
		    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
		        $allowedMethods = $routeInfo[1];
		        $response->status(405);
		        $response->end(implode('', $allowedMethods) );
		        break;
		    case \FastRoute\Dispatcher::FOUND:
		    	$request->dispatch = $routeInfo;
		    	$res = $this->initCoreMiddleware($request);var_dump($res);
		        $response->end($res);
		        break;
		}
	}

	public function initCoreMiddleware($request)
	{
		$middles = require BASE_PATH. '/config/autoload/middles.php';
		$middles[] = \Kenel\HttpServer\HttpMiddle::class;
		$handle = array_reduce(array_reverse($middles) ,[$this,'carry']);
		return $handle($request);
		
	}

	public function carry($carry, $item)
	{
		return function($request) use ($carry, $item){
			if($item instanceof Closure){
				return call_user_func($item,$request, $carry);
			}else{
				return call_user_func([new $item,'handle'],$request, $carry);
			}
			
		};
	}

	public function initRouter()
	{
		$this->dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) {
			$routes = require BASE_PATH. '/config/routes.php';
			foreach ($routes as $k => $v) {
				$r->addRoute($v[0], $v[1], $v[2]);
			}
		});
	}
}