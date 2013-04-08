<?php

namespace spec\MageTool\Command;

use PHPSpec2\ObjectBehavior;

class IndexerRunCommand extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('MageTool\Command\IndexerRunCommand');
    }
}
