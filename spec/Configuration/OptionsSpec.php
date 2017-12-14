<?php

namespace spec\AutoMapperPlus\Configuration;

use AutoMapperPlus\Configuration\Options;
use PhpSpec\ObjectBehavior;

class OptionsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Options::class);
    }
}
