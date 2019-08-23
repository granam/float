<?php declare(strict_types=1);

namespace Granam\Tests\Float\Tools;

use Granam\Float\FloatObject;
use Granam\Float\NegativeFloatObject;
use Granam\Float\PositiveFloatObject;
use Granam\Float\Tools\ToFloat;
use Granam\Tests\Float\ICanUseItSameWayAsUsing;

class ToFloatTest extends ICanUseItSameWayAsUsing
{
    /**
     * @test
     * @throws \ReflectionException
     */
    public function I_can_use_it_just_with_value_parameter(): void
    {
        parent::assertUsableWithJustValueParameter(ToFloat::class, 'toFloat');
    }

    /**
     * @test
     * @throws \ReflectionException
     */
    public function I_can_use_it_same_way_as_using_number_object(): void
    {
        $this->I_can_use_it_same_way_as_using('toFloat', FloatObject::class);
        $this->I_can_use_it_same_way_as_using('toPositiveFloat', PositiveFloatObject::class);
        $this->I_can_use_it_same_way_as_using('toNegativeFloat', NegativeFloatObject::class);
    }

    /**
     * @test
     * @dataProvider provideValueOrNull
     * @param $value
     * @param float|null $expectedValue
     */
    public function I_can_get_float_or_null($value, ?float $expectedValue): void
    {
        self::assertSame($expectedValue, ToFloat::toFloatOrNull($value));
        if ($expectedValue === null || $expectedValue <= 0) {
            self::assertSame($expectedValue, ToFloat::toNegativeFloatOrNull($value));
        }
        if ($expectedValue === null || $expectedValue >= 0) {
            self::assertSame($expectedValue, ToFloat::toPositiveFloatOrNull($value));
        }
    }

    public function provideValueOrNull(): array
    {
        return [
            [null, null],
            [1.1, 1.1],
            [new FloatObject(-159.654), -159.654],
            ['999.111', 999.111],
        ];
    }
}