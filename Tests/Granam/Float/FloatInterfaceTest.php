<?php
namespace Granam\Float;

class FloatInterfaceTest extends \PHPUnit_Framework_TestCase
{

    /** @test */
    public function inherits_from_scalar_interface()
    {
        $this->assertTrue(is_a('Granam\Float\FloatInterface', 'Granam\Number\NumberInterface', true /* accept class name instead of instance */));
    }
}
