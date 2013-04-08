<?php

namespace spec\MageTool;

use PHPSpec2\ObjectBehavior;

class ServiceContainer extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('MageTool\ServiceContainer');
    }
}
