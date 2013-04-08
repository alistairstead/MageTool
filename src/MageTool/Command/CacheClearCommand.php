<?php

namespace MageTool\Command;

use Symfony\Component\Console\Input\InputInterface;
use MageTool\ServiceContainer;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class CacheClearCommand extends Command
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
            ->setName('cache:clear')
            ->setDefinition(array())
            ->setDescription('Clear Magento cache')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command will refresh The
Magento cache where it is invalidated.
EOF
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getCacheInstance()->clean(array());

        $output->writeln("<info>Cache Cleared Successfully!</info>\n");
    }

    protected function getCacheInstance()
    {
        $app = $this->container->getApp();

        return $app->getCacheInstance();
    }

}
