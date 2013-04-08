<?php

namespace spec\MageTool\Command;

use PHPSpec2\ObjectBehavior;

class CacheStatusCommand extends ObjectBehavior
{
    /**
     * @param MageTool\ServiceContainer $container
     */
    public function let($container)
    {
        $this->beConstructedWith($container);
    }

    public function it_should_be_initializable()
    {
        $this->shouldHaveType('Symfony\Component\Console\Command\Command');
    }

    public function it_should_return_name_from_getName()
    {
        $this->getName()->shouldReturn('cache:status');
    }
}
