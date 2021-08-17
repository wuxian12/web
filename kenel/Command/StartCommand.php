<?php

namespace Kenel\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Kenel\Server\ServerFactory;
use Kenel\Config\ConfigFactory;
 
class StartCommand extends Command
{
    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        // 命令的名字（"bin/console" 后面的部分）
        ->setName('start')
        // the short description shown while running "php bin/console list"
        // 运行 "php bin/console list" 时的简短描述
        ->setDescription('app server start')
    	;
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configFactory = (new ConfigFactory)();
        $serverFactory = new ServerFactory();
        $serverFactory->configure($configFactory->get('server'));
        $serverFactory->start();
    }
}