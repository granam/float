<?php declare(strict_types=1);

declare(strict_types = 1);

namespace Granam\Tests\Float;

use Granam\Float\FloatInterface;
use Granam\Float\FloatObject;
use Granam\Number\NumberInterface;

class FloatObjectTest extends ICanUseItSameWayAsUsing
{
    /**
     * @test
     * @throws \ReflectionException
     */
    public function I_can_use_it_just_with_value_parameter(): void
    {
        parent::assertUsableWithJustValueParameter(FloatObject::class, '__construct');
    }

    /**
     * @test
     * @throws \ReflectionException
     */
    public function I_can_create_it_same_way_as_using_to_float_tool(): void
    {
        $this->I_can_use_it_same_way_as_using('toFloat', FloatObject::class);
    }

    /**
     * @test
     * @dataProvider provideStrictnessAndParanoia
     * @param bool $strict
     * @param bool $paranoid
     */
    public function I_can_create_float_object(bool $strict, bool $paranoid): void
    {
        $floatObject = new FloatObject($float = 123.456, $strict, $paranoid);
        self::assertNotNull($floatObject);
        self::assertInstanceOf(FloatInterface::class, $floatObject);
        self::assertInstanceOf(NumberInterface::class, $floatObject);
        self::assertSame($float, $floatObject->getValue());
    }

    public function provideStrictnessAndParanoia(): array
    {
        return [
            [false, false],
            [false, true],
            [true, false],
            [true, true],
        ];
    }

    /**
     * @test
     * @dataProvider provideStrictnessAndParanoia
     * @param bool $strict
     * @param bool $paranoid
     */
    public function I_can_use_float_object_as_string(bool $strict, bool $paranoid): void
    {
        $floatObject = new FloatObject($float = 123.456, $strict, $paranoid);
        self::assertSame((string)$float, (string)$floatObject);
    }

    /**
     * @test
     * @dataProvider provideStrictnessAndParanoia
     * @param bool $strict
     * @param bool $paranoid
     */
    public function I_can_use_integer_value(bool $strict, bool $paranoid): void
    {
        $floatObject = new FloatObject($integer = 123, $strict, $paranoid);
        self::assertSame((float)$integer, $floatObject->getValue());
    }

    /**
     * @test
     * @dataProvider provideStrictnessAndParanoia
     * @param bool $strict
     * @param bool $paranoid
     */
    public function I_can_use_false_as_float_zero(bool $strict, bool $paranoid): void
    {
        $floatObject = new FloatObject(false, $strict, $paranoid);
        self::assertSame(0.0, $floatObject->getValue());
        self::assertSame((float)false, $floatObject->getValue());
    }

    /**
     * @test
     * @dataProvider provideStrictnessAndParanoia
     * @param bool $strict
     * @param bool $paranoid
     */
    public function I_can_use_true_as_float_one(bool $strict, bool $paranoid): void
    {
        $floatObject = new FloatObject(true, $strict, $paranoid);
        self::assertSame(1.0, $floatObject->getValue());
        self::assertSame((float)true, $floatObject->getValue());
    }

    /**
     * @test
     * @dataProvider provideParanoia
     * @param bool $paranoid
     */
    public function I_can_use_null_and_empty_string_as_float_zero_if_not_strict($paranoid): void
    {
        $fromNull = new FloatObject(null, false /* not strict */, $paranoid);
        self::assertSame(0.0, $fromNull->getValue());
        self::assertSame((float)null, $fromNull->getValue());

        $fromEmptyString = new FloatObject('', false /* not strict */, $paranoid);
        self::assertEquals($fromNull, $fromEmptyString);
        self::assertSame(0.0, $fromEmptyString->getValue());
        self::assertSame((float)'', $fromEmptyString->getValue());

        $fromWhiteCharacters = new FloatObject(
            $whiteCharacters = "\n\t  \r",
            false /* not strict */,
            $paranoid
        );
        self::assertEquals($fromNull, $fromWhiteCharacters);
        self::assertSame(0.0, $fromWhiteCharacters->getValue());
        self::assertSame((float)$whiteCharacters, $fromWhiteCharacters->getValue());
    }

    public function provideParanoia(): array
    {
        return [
            [true],
            [false]
        ];
    }

    /**
     * @test
     * @dataProvider provideNonNumericNonBoolean
     * @param $value
     */
    public function I_can_not_use_non_numeric_non_boolean_by_default($value): void
    {
        $this->expectException(\Granam\Float\Tools\Exceptions\WrongParameterType::class);
        new FloatObject($value);
    }

    public function provideNonNumericNonBoolean(): array
    {
        return [
            [null],
            [''],
            ["  \n\t  \r"],
            ['one']
        ];
    }

    /**
     * @test
     * @dataProvider provideStrictnessAndParanoia
     * @param bool $strict
     * @param bool $paranoid
     */
    public function I_cannot_use_array(bool $strict, bool $paranoid): void
    {
        $this->expectException(\Granam\Float\Tools\Exceptions\WrongParameterType::class);
        new FloatObject([], $strict, $paranoid);
    }

    /**
     * @test
     * @dataProvider provideStrictnessAndParanoia
     * @param bool $strict
     * @param bool $paranoid
     */
    public function I_cannot_use_resource(bool $strict, bool $paranoid): void
    {
        $this->expectException(\Granam\Float\Tools\Exceptions\WrongParameterType::class);
        new FloatObject(tmpfile(), $strict, $paranoid);
    }

    /**
     * @test
     * @dataProvider provideStrictnessAndParanoia
     * @param bool $strict
     * @param bool $paranoid
     */
    public function I_cannot_use_object(bool $strict, bool $paranoid): void
    {
        $this->expectException(\Granam\Float\Tools\Exceptions\WrongParameterType::class);
        new FloatObject(new \stdClass(), $strict, $paranoid);
    }

    /**
     * @test
     * @dataProvider provideStrictnessAndParanoia
     * @param bool $strict
     * @param bool $paranoid
     */
    public function I_can_use_object_with_to_string(bool $strict, bool $paranoid): void
    {
        $floatObject = new FloatObject(new TestWithToString($float = 123.456), $strict, $paranoid);
        self::assertSame($float, $floatObject->getValue());
        $stringFloatObject = new FloatObject(new TestWithToString($stringFloat = '987.654'), $strict, $paranoid);
        self::assertSame((float)$stringFloat, $stringFloatObject->getValue());
    }

    /**
     * @test
     */
    public function I_get_to_string_object_without_number_as_float_zero_if_not_strict(): void
    {
        $float = new FloatObject(new TestWithToString($string = 'non-float'), false /* not strict */);
        self::assertSame(0.0, $float->getValue());
        self::assertSame((float)$string, $float->getValue());
    }

    /**
     * @test
     * @dataProvider provideStrictnessAndParanoia
     * @param bool $strict
     * @param bool $paranoid
     */
    public function I_get_value_without_wrapping_trash(bool $strict, bool $paranoid): void
    {
        $withWrappingZeroes = new FloatObject($zeroWrappedNumber = '0000123456.789000', $strict, $paranoid);
        self::assertSame(123456.789, $withWrappingZeroes->getValue());
        self::assertSame((float)$zeroWrappedNumber, $withWrappingZeroes->getValue());
        $integerLike = new FloatObject($integerLikeNumber = '0000123456.0000', $strict, $paranoid);
        self::assertSame(123456.0, $integerLike->getValue());
        self::assertSame((float)$integerLikeNumber, $integerLike->getValue());
    }

    /**
     * @test
     */
    public function I_get_number_cleared_of_leading_non_number_trash_if_not_strict(): void
    {
        $trashAround = new FloatObject($trashWrappedNumber = '   123456.0051500  foo bar 12565.04181 ', false /* not strict */);
        self::assertSame(123456.00515, $trashAround->getValue());
        self::assertSame((float)$trashWrappedNumber, $trashAround->getValue());
    }

    /**
     * @test
     */
    public function I_can_not_use_number_with_leading_non_number_trash_by_default(): void
    {
        $this->expectException(\Granam\Float\Tools\Exceptions\WrongParameterType::class);
        new FloatObject($trashWrappedNumber = '   123456.0051500  foo bar 12565.04181 ');
    }

    /**
     * @test
     */
    public function Rounding_is_done_silently_by_default(): void
    {
        $float = new FloatObject($withTooLongDecimal = '123456.999999999999999999999999999999999999');
        self::assertSame(123457.0, $float->getValue());
        self::assertSame((float)$withTooLongDecimal, $float->getValue());
        $float = new FloatObject($withTooLongInteger = '222222222222222222222222222222222222222222.123');
        self::assertSame(2.2222222222222224E+41, $float->getValue());
        self::assertSame((float)$withTooLongInteger, $float->getValue());
    }

    /**
     * @test
     * @dataProvider provideStrictness
     * @param bool $strict
     */
    public function I_can_force_exception_in_case_of_rounding($strict): void
    {
        $this->expectException(\Granam\Float\Tools\Exceptions\ValueLostOnCast::class);
        try {
            $floatObject = new FloatObject($floatValue = '123456.999', $strict, true /* paranoid */);
            self::assertSame((float)$floatValue, $floatObject->getValue());
        } catch (\Exception $exception) {
            self::fail('Unexpected any exception here: ' . $exception->getMessage());
        }
        new FloatObject('123456.999999999999999999999999999999999999', $strict, true /* paranoid */);
        self::fail('Rounding has not been detected');
    }

    public function provideStrictness(): array
    {
        return [
            [true],
            [false],
        ];
    }

}

/** inner */
class TestWithToString
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return (string)$this->value;
    }
}