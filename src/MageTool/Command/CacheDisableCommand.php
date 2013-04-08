<?php

namespace MageTool\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class CacheDisableCommand extends CacheClearCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->ignoreValidationErrors();

        $this
            ->setName('cache:disable')
            ->setDefinition(array())
            ->setDescription('Disable Magento cache')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command displays help for a given command:

    <info>php %command.full_name% list</info>

You can also output the help as XML by using the <comment>--xml</comment> option:

    <info>php %command.full_name% --xml list</info>

To display the list of available commands, please use the <info>list</info> command.
EOF
            )
        ;
    }
}
