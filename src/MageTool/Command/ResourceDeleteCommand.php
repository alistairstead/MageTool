<?php

namespace MageTool\Command;

use Symfony\Component\Console\Input\InputInterface;
use MageTool\ServiceContainer;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class ResourceDeleteCommand extends Command
{
    private $container;

    public function __construct(ServiceContainer $container)
    {
        $this->container = $container;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->ignoreValidationErrors();

        $this
            ->setName('resource:delete')
            ->setDefinition(array())
            ->setDescription('Delete a core_resource recorde')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command will delete a core_resource
record so that the module setup is run on next request.
EOF
            )
        ;
    }

}
