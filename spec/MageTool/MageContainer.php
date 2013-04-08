<?php

namespace spec\MageTool;

use PHPSpec2\ObjectBehavior;

class MageContainer extends ObjectBehavior
{
    function it_should_be_initializable()
    {
        $this->shouldHaveType('MageTool\MageContainer');
    }

    /**
     * @param  Mage_Core_App $app
     */
    function it_should_return_app($app)
    {
        $this->setApp($app);
        $this->getApp()->shouldReturn($app);
    }
}

class Mage_Core_App {

}
