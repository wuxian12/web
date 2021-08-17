<?php
namespace Kenel\HttpServer;

class HttpMiddle
{
	public function handle($request)
	{
		$routeInfo = $request->dispatch;
		$handler = $routeInfo[1];
		$vars = $routeInfo[2];
		$arr = explode('@', $handler);
		return (new $arr[0])->{$arr[1]}();
		
	}
}