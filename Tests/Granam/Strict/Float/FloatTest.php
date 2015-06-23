<?php
namespace Granam\Float;

class FloatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * 
     * @return Float
     */
    public function can_create_instance()
    {
        $instance = new Float(123.456);
        $this->assertNotNull($instance);

        return $instance;
    }

    /**
     * @param Float $float
     *
     * @test
     *
     * @depends can_create_instance
     */
    public function has_local_interface(Float $float)
    {
        $this->assertInstanceOf('Granam\Float\FloatInterface', $float);
    }

    /**
     * @test
     *
     * @depends can_create_instance
     */
    public function gives_same_value_as_created_with()
    {
        $nonStrict = new Float($float = 123.456);
        $this->assertSame($float, $nonStrict->getValue());
    }

    /**
     * @test
     *
     * @depends gives_same_value_as_created_with
     */
    public function can_be_turned_into_string()
    {
        $floatObject = new Float($float = 123.456);
        $this->assertSame((string)$float, (string)$floatObject);
    }

    /**
     * @test
     */
    public function integer_is_accepted()
    {
        $floatObject = new Float($integer = 123);
        $this->assertSame(floatval($integer), $floatObject->getValue());
    }

    /**
     * @test
     */
    public function false_is_float_zero()
    {
        $floatObject = new Float(false);
        $this->assertSame(0.0, $floatObject->getValue());
        $this->assertSame(floatval(false), $floatObject->getValue());
    }

    /**
     * @test
     */
    public function true_is_float_one()
    {
        $floatObject = new Float(true);
        $this->assertSame(1.0, $floatObject->getValue());
        $this->assertSame(floatval(true), $floatObject->getValue());
    }

    /**
     * @test
     */
    public function null_is_zero()
    {
        $floatObject = new Float(null);
        $this->assertSame(0.0, $floatObject->getValue());
        $this->assertSame(floatval(null), $floatObject->getValue());
    }

    /**
     * @test
     * @expectedException \Granam\Float\Exceptions\WrongParameterType
     */
    public function array_cause_exception()
    {
        new Float([]);
    }

    /**
     * @test
     * @expectedException \Granam\Float\Exceptions\WrongParameterType
     */
    public function resource_cause_exception()
    {
        new Float(tmpfile());
    }

    /**
     * @test
     * @expectedException \Granam\Float\Exceptions\WrongParameterType
     */
    public function object_cause_exception()
    {
        new Float(new \stdClass());
    }

    /**
     * @test
     */
    public function to_string_object_is_that_object_float_value()
    {
        $floatObject = new Float(new TestWithToString($float = 123.456));
        $this->assertSame($float, $floatObject->getValue());
        $stringFloatObject = new Float(new TestWithToString($stringFloat = '987.654'));
        $this->assertSame(floatval($stringFloat), $stringFloatObject->getValue());
    }

    /**
     * @test
     */
    public function to_string_object_without_float_is_zero()
    {
        $float = new Float(new TestWithToString($string = 'non-float'));
        $this->assertSame(0.0, $float->getValue());
        $this->assertSame(floatval($string), $float->getValue());
    }

    /**
     * @test
     */
    public function wrapping_trash_is_trimmed()
    {
        $withWrappingZeroes = new Float($zeroWrappedNumber = '0000123456.789000');
        $this->assertSame(123456.789, $withWrappingZeroes->getValue());
        $this->assertSame(floatval($zeroWrappedNumber), $withWrappingZeroes->getValue());
        $integerLike = new Float($integerLikeNumber = '0000123456.0000');
        $this->assertSame(123456.0, $integerLike->getValue());
        $this->assertSame(floatval($integerLikeNumber), $integerLike->getValue());
        $trashAround = new Float($trashWrappedNumber = '   123456.0051500  foo bar 12565.04181 ');
        $this->assertSame(123456.00515, $trashAround->getValue());
        $this->assertSame(floatval($trashWrappedNumber), $trashAround->getValue());
    }

    /**
     * @test
     */
    public function lost_value_is_not_detected_by_default()
    {
        $float = new Float($withTooLongDecimal = '123456.999999999999999999999999999999999999');
        $this->assertSame(123457.0, $float->getValue());
        $this->assertSame(floatval($withTooLongDecimal), $float->getValue());
        $float = new Float($withTooLongInteger = '222222222222222222222222222222222222222222.123');
        $this->assertSame(2.2222222222222224E+41, $float->getValue());
        $this->assertSame(floatval($withTooLongInteger), $float->getValue());
    }

    /**
     * @test
     * @expectedException \Granam\Float\Tools\Exceptions\ValueLostOnCast
     */
    public function lost_decimal_value_can_be_detected()
    {
        new Float('123456.999999999999999999999999999999999999', true /* paranoid */);
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
