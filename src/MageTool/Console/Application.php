<?php

namespace MageTool\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;

use MageTool\MageTool;
use MageTool\Command;
use MageTool\ServiceContainer;

class Application extends BaseApplication
{
    private $container;
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->container = $c = new ServiceContainer;

        $c->set('console.commands', array());

        // Cache
        $c->extend('console.commands', function($c) {
            return new Command\CacheClearCommand($c);
        });
        $c->extend('console.commands', function($c) {
            return new Command\CacheDisableCommand($c);
        });
        $c->extend('console.commands', function($c) {
            return new Command\CacheEnableCommand($c);
        });
        $c->extend('console.commands', function($c) {
            return new Command\CacheFlushCommand($c);
        });
        $c->extend('console.commands', function($c) {
            return new Command\CacheStatusCommand($c);
        });
        // Config
        $c->extend('console.commands', function($c) {
            return new Command\ConfigLintCommand($c);
        });
        $c->extend('console.commands', function($c) {
            return new Command\ConfigReplaceCommand($c);
        });
        $c->extend('console.commands', function($c) {
            return new Command\ConfigSetCommand($c);
        });
        $c->extend('console.commands', function($c) {
            return new Command\ConfigShowCommand($c);
        });
        // Indexer
        $c->extend('console.commands', function($c) {
            return new Command\IndexerModeCommand($c);
        });
        $c->extend('console.commands', function($c) {
            return new Command\IndexerRunCommand($c);
        });
        $c->extend('console.commands', function($c) {
            return new Command\IndexerStatusCommand($c);
        });
        // Resource
        $c->extend('console.commands', function($c) {
            return new Command\ResourceDeleteCommand($c);
        });
        $c->extend('console.commands', function($c) {
            return new Command\ResourceShowCommand($c);
        });
        $c->extend('console.commands', function($c) {
            return new Command\ResourceUpdateCommand($c);
        });


        parent::__construct('MageTool', MageTool::VERSION);
    }

    /**
     * Initializes all the MageTool commands
     */
    protected function getDefaultCommands()
    {
        $commands = parent::getDefaultCommands();
        foreach ($this->container->get('console.commands') as $command) {
            $commands[] = $command;
        }

        return $commands;
    }
}
