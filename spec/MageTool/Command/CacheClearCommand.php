<?php

namespace spec\MageTool\Command;

use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Output\Output;

use PHPSpec2\ObjectBehavior;

class CacheClearCommand extends ObjectBehavior
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

    function it_should_return_name_from_getName($input, $output)
    {
        $this->getName()->shouldReturn('cache:clear');
    }

    /**
     * @param Symfony\Component\Console\Input\Input $input
     * @param Symfony\Component\Console\Output\Output $output
     */
    function it_should_return_success_from_execute($input, $output)
    {
        $this->execute($input, $output)->shouldReturn('Success!');
    }

    /**
     * @param Symfony\Component\Console\Input\Input $input
     * @param Symfony\Component\Console\Output\Output $output
     * @param Mage_Core_App $app
     * @param Mage_Core_Cache $cacheInstance
     */
    function it_should_clear_cache($input, $output, $container, $app, $cacheInstance)
    {
        $cacheInstance->clear()->shouldBeCalled();
        $app->getCacheInstance()->willReturn($cacheInstance);
        $app->getCacheInstance()->shouldBeCalled();
        $container->setApp($app);
        $this->execute($input, $output);
    }
}
