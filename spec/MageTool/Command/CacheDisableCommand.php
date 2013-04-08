<?php

namespace spec\MageTool\Command;

use PHPSpec2\ObjectBehavior;

class CacheDisableCommand extends ObjectBehavior
{
    /**
     * @param MageTool\MageContainer $container
     */
    function let($container)
    {
        $this->beConstructedWith($container);
    }

    function it_should_be_initializable()
    {
        $this->shouldHaveType('Symfony\Component\Console\Command\Command');
    }

    function it_should_return_name_from_getName()
    {
        $this->getName()->shouldReturn('cache:disable');
    }
}
