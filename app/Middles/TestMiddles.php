<?php
namespace App\Middles;

class TestMiddles
{
	public function handle($request, $next)
	{
		var_dump(123);
		return $next($request);
	
	}
}