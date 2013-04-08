<?php

namespace MageTool\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

class CacheFlushCommand extends CacheClearCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->ignoreValidationErrors();

        $this
            ->setName('cache:flush')
            ->setDefinition(array())
            ->setDescription('Flush Magento cache')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command will flush The
Magento cache.
EOF
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getCacheInstance()->flush();

        $output->writeln("<info>Cache Flushed Successfully!</info>\n");
    }
}
