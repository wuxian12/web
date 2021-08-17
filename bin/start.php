<?php

use Symfony\Component\Console\Application;
use Kenel\Command\StartCommand;

! defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1));

require BASE_PATH . '/vendor/autoload.php';

$application = new Application();
 
$application->add(new StartCommand());
 
$application->run();