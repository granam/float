<?php
namespace Granam\Tests\Float;

class FloatInterfaceTest extends \PHPUnit_Framework_TestCase
{

    /** @test */
    public function inherits_from_scalar_interface()
    {
        self::assertTrue(is_a('Granam\Float\FloatInterface', 'Granam\Number\NumberInterface', true /* accept class name instead of instance */));
    }
}
