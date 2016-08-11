<?php
namespace Granam\Tests\Float;

use Granam\Float\PositiveFloatObject;

class PositiveFloatObjectTest extends ICanUseItSameWayAsUsing
{
    /**
     * @test
     */
    public function I_can_use_it_as_float()
    {
        self::assertTrue(is_a(PositiveFloatObject::getClass(), '\Granam\Float\FloatInterface', true));
    }

    /**
     * @test
     */
    public function I_can_create_it_with_zero_and_greater_value()
    {
        $zero = new PositiveFloatObject(0);
        self::assertSame(0.0, $zero->getValue());
        $greaterThanZero = new PositiveFloatObject(123.456);
        self::assertSame(123.456, $greaterThanZero->getValue());
    }

    /**
     * @test
     */
    public function I_can_use_it_same_way_as_using_to_positive_float_tool()
    {
        $this->I_can_use_it_same_way_as_using('toPositiveFloat', PositiveFloatObject::getClass());
    }

    /**
     * @test
     * @expectedException \Granam\Float\Tools\Exceptions\PositiveFloatCanNotBeNegative
     */
    public function I_can_not_create_it_negative()
    {
        new PositiveFloatObject(-0.004);
    }
}