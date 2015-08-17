<?php
namespace Granam\Float;

class FloatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_create_float_object()
    {
        $floatObject = new FloatObject(123.456);
        $this->assertNotNull($floatObject);
        $this->assertInstanceOf('Granam\Float\FloatInterface', $floatObject);
    }

    /**
     * @test
     */
    public function I_can_get_value()
    {
        $floatObject = new FloatObject($float = 123.456);
        $this->assertSame($float, $floatObject->getValue());
    }

    /**
     * @test
     */
    public function I_can_use_float_object_as_string()
    {
        $floatObject = new FloatObject($float = 123.456);
        $this->assertSame((string)$float, (string)$floatObject);
    }

    /**
     * @test
     */
    public function I_can_use_integer_value()
    {
        $floatObject = new FloatObject($integer = 123);
        $this->assertSame(floatval($integer), $floatObject->getValue());
    }

    /**
     * @test
     */
    public function I_can_use_false_as_float_zero()
    {
        $floatObject = new FloatObject(false);
        $this->assertSame(0.0, $floatObject->getValue());
        $this->assertSame(floatval(false), $floatObject->getValue());
    }

    /**
     * @test
     */
    public function I_can_use_true_as_float_one()
    {
        $floatObject = new FloatObject(true);
        $this->assertSame(1.0, $floatObject->getValue());
        $this->assertSame(floatval(true), $floatObject->getValue());
    }

    /**
     * @test
     */
    public function I_can_use_null_as_float_zero()
    {
        $floatObject = new FloatObject(null);
        $this->assertSame(0.0, $floatObject->getValue());
        $this->assertSame(floatval(null), $floatObject->getValue());
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
        $this->assertSame($float, $floatObject->getValue());
        $stringFloatObject = new FloatObject(new TestWithToString($stringFloat = '987.654'));
        $this->assertSame(floatval($stringFloat), $stringFloatObject->getValue());
    }

    /**
     * @test
     */
    public function I_get_to_string_object_without_float_as_float_zero()
    {
        $float = new FloatObject(new TestWithToString($string = 'non-float'));
        $this->assertSame(0.0, $float->getValue());
        $this->assertSame(floatval($string), $float->getValue());
    }

    /**
     * @test
     */
    public function I_get_value_withouth_wrapping_trash()
    {
        $withWrappingZeroes = new FloatObject($zeroWrappedNumber = '0000123456.789000');
        $this->assertSame(123456.789, $withWrappingZeroes->getValue());
        $this->assertSame(floatval($zeroWrappedNumber), $withWrappingZeroes->getValue());
        $integerLike = new FloatObject($integerLikeNumber = '0000123456.0000');
        $this->assertSame(123456.0, $integerLike->getValue());
        $this->assertSame(floatval($integerLikeNumber), $integerLike->getValue());
        $trashAround = new FloatObject($trashWrappedNumber = '   123456.0051500  foo bar 12565.04181 ');
        $this->assertSame(123456.00515, $trashAround->getValue());
        $this->assertSame(floatval($trashWrappedNumber), $trashAround->getValue());
    }

    /**
     * @test
     */
    public function Rounding_is_done_silently_by_default()
    {
        $float = new FloatObject($withTooLongDecimal = '123456.999999999999999999999999999999999999');
        $this->assertSame(123457.0, $float->getValue());
        $this->assertSame(floatval($withTooLongDecimal), $float->getValue());
        $float = new FloatObject($withTooLongInteger = '222222222222222222222222222222222222222222.123');
        $this->assertSame(2.2222222222222224E+41, $float->getValue());
        $this->assertSame(floatval($withTooLongInteger), $float->getValue());
    }

    /**
     * @test
     * @expectedException \Granam\Float\Tools\Exceptions\ValueLostOnCast
     */
    public function I_can_force_exception_in_case_of_rounding()
    {
        try {
            $floatObject = new FloatObject($floatValue = '123456.999', true /* paranoid */);
            $this->assertSame(floatval($floatValue), $floatObject->getValue());
        } catch (\Exception $exception) {
            $this->fail('Unexpected any exception here: ' . $exception->getMessage());
        }
        try {
            new FloatObject('123456.999999999999999999999999999999999999', true /* paranoid */);
            $this->fail('Rounding has not been detected');
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
