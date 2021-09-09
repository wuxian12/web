<?php
namespace App\Controller;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class HealthController
{
	public function health()
	{
		$capsule = new Capsule;

		$capsule->addConnection([
		    'driver' => 'mysql',
		    'host' => '192.168.0.37',
		    'database' => 'chat',
		    'username' => 'y3-dev',
		    'password' => 'NkDX2Fh3w1Si',
		    'charset' => 'utf8',
		    'collation' => 'utf8_unicode_ci',
		    'prefix' => 'chat_',
		]);

		// Set the event dispatcher used by Eloquent models... (optional)
		
		//$capsule->setEventDispatcher(new Dispatcher(new Container));

		// Make this Capsule instance available globally via static methods... (optional)
		$capsule->setAsGlobal();

		// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
		$capsule->bootEloquent();
		$users = Capsule::table('vpn')->where('status', '>', 1)->orderBy('id','desc')->get();
		Capsule::table('vpn')
              ->where('id', 15)
              ->update(['area' => 123]);


		
		return 456;
	}
}