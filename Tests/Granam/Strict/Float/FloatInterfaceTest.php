<?php
namespace Granam\Strict\Float;

class FloatInterfaceTest extends \PHPUnit_Framework_TestCase
{

    /** @test */
    public function inherits_from_scalar_interface()
    {
        $this->assertTrue(is_a('Granam\Float\FloatInterface', 'Granam\Scalar\ScalarInterface', true /* accept class name instead of instance */));
    }
}
