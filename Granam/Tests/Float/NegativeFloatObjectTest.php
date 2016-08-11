<?php
namespace Granam\Tests\Float;

use Granam\Float\NegativeFloatObject;

class NegativeFloatObjectTest extends ICanUseItSameWayAsUsing
{
    /**
     * @test
     */
    public function I_can_use_it_as_float()
    {
        self::assertTrue(is_a(NegativeFloatObject::getClass(), '\Granam\Float\FloatInterface', true));
    }

    /**
     * @test
     */
    public function I_can_create_it_with_zero_and_lesser_value()
    {
        $zero = new NegativeFloatObject(0);
        self::assertSame(0.0, $zero->getValue());
        $lesserThanZero = new NegativeFloatObject(-123.456);
        self::assertSame(-123.456, $lesserThanZero->getValue());
    }

    /**
     * @test
     */
    public function I_can_use_it_same_way_as_using_to_negative_float_tool()
    {
        $this->I_can_use_it_same_way_as_using('toNegativeFloat', NegativeFloatObject::getClass());
    }

    /**
     * @test
     * @expectedException \Granam\Float\Tools\Exceptions\NegativeFloatCanNotBePositive
     */
    public function I_can_not_create_it_positive()
    {
        new NegativeFloatObject(0.01);
    }
}