<?php

namespace spec\MageTool\Command;

use PHPSpec2\ObjectBehavior;

class ConfigShowCommand extends ObjectBehavior
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
        $this->shouldHaveType('MageTool\Command\ConfigShowCommand');
    }
}
