<?php
namespace Granam\Tests\Float;

use Granam\Float\FloatObject;

class FloatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_create_float_object()
    {
        $floatObject = new FloatObject(123.456);
        self::assertNotNull($floatObject);
        self::assertInstanceOf('Granam\Float\FloatInterface', $floatObject);
    }

    /**
     * @test
     */
    public function I_can_get_value()
    {
        $floatObject = new FloatObject($float = 123.456);
        self::assertSame($float, $floatObject->getValue());
    }

    /**
     * @test
     */
    public function I_can_use_float_object_as_string()
    {
        $floatObject = new FloatObject($float = 123.456);
        self::assertSame((string)$float, (string)$floatObject);
    }

    /**
     * @test
     */
    public function I_can_use_integer_value()
    {
        $floatObject = new FloatObject($integer = 123);
        self::assertSame((float)$integer, $floatObject->getValue());
    }

    /**
     * @test
     */
    public function I_can_use_false_as_float_zero()
    {
        $floatObject = new FloatObject(false);
        self::assertSame(0.0, $floatObject->getValue());
        self::assertSame((float)false, $floatObject->getValue());
    }

    /**
     * @test
     */
    public function I_can_use_true_as_float_one()
    {
        $floatObject = new FloatObject(true);
        self::assertSame(1.0, $floatObject->getValue());
        self::assertSame((float)true, $floatObject->getValue());
    }

    /**
     * @test
     */
    public function I_can_use_null_as_float_zero()
    {
        $floatObject = new FloatObject(null);
        self::assertSame(0.0, $floatObject->getValue());
        self::assertSame((float)null, $floatObject->getValue());
    }

    /**
     * @test
     * @expectedException \Granam\Float\Exceptions\WrongParameterType
     */
    public function I_cannot_use_array()
    {
        new FloatObject([]);
    }

    /**
     * @test
     * @expectedException \Granam\Float\Exceptions\WrongParameterType
     */
    public function I_cannot_use_resource()
    {
        new FloatObject(tmpfile());
    }

    /**
     * @test
     * @expectedException \Granam\Float\Exceptions\WrongParameterType
     */
    public function I_cannot_use_object()
    {
        new FloatObject(new \stdClass());
    }

    /**
     * @test
     */
    public function I_can_use_object_with_to_string()
    {
        $floatObject = new FloatObject(new TestWithToString($float = 123.456));
        self::assertSame($float, $floatObject->getValue());
        $stringFloatObject = new FloatObject(new TestWithToString($stringFloat = '987.654'));
        self::assertSame((float)$stringFloat, $stringFloatObject->getValue());
    }

    /**
     * @test
     */
    public function I_get_to_string_object_without_float_as_float_zero()
    {
        $float = new FloatObject(new TestWithToString($string = 'non-float'));
        self::assertSame(0.0, $float->getValue());
        self::assertSame((float)$string, $float->getValue());
    }

    /**
     * @test
     */
    public function I_get_value_withouth_wrapping_trash()
    {
        $withWrappingZeroes = new FloatObject($zeroWrappedNumber = '0000123456.789000');
        self::assertSame(123456.789, $withWrappingZeroes->getValue());
        self::assertSame((float)$zeroWrappedNumber, $withWrappingZeroes->getValue());
        $integerLike = new FloatObject($integerLikeNumber = '0000123456.0000');
        self::assertSame(123456.0, $integerLike->getValue());
        self::assertSame((float)$integerLikeNumber, $integerLike->getValue());
        $trashAround = new FloatObject($trashWrappedNumber = '   123456.0051500  foo bar 12565.04181 ');
        self::assertSame(123456.00515, $trashAround->getValue());
        self::assertSame((float)$trashWrappedNumber, $trashAround->getValue());
    }

    /**
     * @test
     */
    public function Rounding_is_done_silently_by_default()
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
     * @expectedException \Granam\Float\Tools\Exceptions\ValueLostOnCast
     */
    public function I_can_force_exception_in_case_of_rounding()
    {
        try {
            $floatObject = new FloatObject($floatValue = '123456.999', true /* paranoid */);
            self::assertSame((float)$floatValue, $floatObject->getValue());
        } catch (\Exception $exception) {
            self::fail('Unexpected any exception here: ' . $exception->getMessage());
        }
        try {
            new FloatObject('123456.999999999999999999999999999999999999', true /* paranoid */);
            self::fail('Rounding has not been detected');
        } catch (\Exception $exception) {
            throw $exception;
        }
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
