<?php

namespace MageTool\Command;

use Symfony\Component\Console\Input\InputInterface;
use MageTool\ServiceContainer;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class ConfigLintCommand extends Command
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
            ->setName('config:lint')
            ->setDefinition(array())
            ->setDescription('Lint Magento xml config')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command will run lint tests against
the xml configuration files.
EOF
            )
        ;
    }
}
