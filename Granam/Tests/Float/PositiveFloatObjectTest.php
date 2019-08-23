<?php declare(strict_types=1);

namespace Granam\Tests\Float;

use Granam\Float\FloatInterface;
use Granam\Float\PositiveFloatObject;

class PositiveFloatObjectTest extends ICanUseItSameWayAsUsing
{
    /**
     * @test
     */
    public function I_can_use_it_as_float(): void
    {
        self::assertTrue(is_a(PositiveFloatObject::class, FloatInterface::class, true));
    }

    /**
     * @test
     */
    public function I_can_create_it_with_zero_and_greater_value(): void
    {
        $zero = new PositiveFloatObject(0);
        self::assertSame(0.0, $zero->getValue());
        $greaterThanZero = new PositiveFloatObject(123.456);
        self::assertSame(123.456, $greaterThanZero->getValue());
    }

    /**
     * @test
     * @throws \ReflectionException
     */
    public function I_can_use_it_same_way_as_using_to_positive_float_tool(): void
    {
        $this->I_can_use_it_same_way_as_using('toPositiveFloat', PositiveFloatObject::class);
    }

    /**
     * @test
     */
    public function I_can_not_create_it_negative(): void
    {
        $this->expectException(\Granam\Float\Tools\Exceptions\PositiveFloatCanNotBeNegative::class);
        new PositiveFloatObject(-0.004);
    }
}