<?php declare(strict_types=1);

namespace Granam\Float\Tools;

use Granam\Number\Tools\ToNumber;
use Granam\Strict\Object\StrictObject;
use Granam\Tools\ValueDescriber;

class ToFloat extends StrictObject
{
    /**
     * @param $value
     * @param bool $strict = true allows only explicit values, empty string and null (remains null)
     * @param bool $paranoid Throws exception if some value is lost on cast due to rounding on cast
     * @return float|null
     * @throws \Granam\Float\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Float\Tools\Exceptions\ValueLostOnCast
     */
    public static function toFloatOrNull($value, bool $strict = true, bool $paranoid = false): ?float
    {
        if ($value === null) {
            return null;
        }

        return static::toFloat($value, $strict, $paranoid);
    }

    /**
     * @param $value
     * @param bool $strict = true allows only explicit values, not null and empty string
     * @param bool $paranoid Throws exception if some value is lost on cast due to rounding on cast
     * @return float
     * @throws \Granam\Float\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Float\Tools\Exceptions\ValueLostOnCast
     */
    public static function toFloat($value, bool $strict = true, bool $paranoid = false): float
    {
        // true = 1; false = 0; null = 0
        return (float)self::convertToNumber($value, $strict, $paranoid);
    }

    /**
     * @param $value
     * @param bool $strict
     * @param bool $paranoid
     * @return float|int
     * @throws \Granam\Float\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Float\Tools\Exceptions\ValueLostOnCast
     */
    private static function convertToNumber($value, bool $strict, bool $paranoid)
    {
        try {
            return ToNumber::toNumber($value, $strict, $paranoid);
        } catch (\Granam\Number\Tools\Exceptions\WrongParameterType $exception) {
            throw new Exceptions\WrongParameterType($exception->getMessage(), $exception->getCode(), $exception);
        } catch (\Granam\Number\Tools\Exceptions\ValueLostOnCast $exception) {
            throw new Exceptions\ValueLostOnCast($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @param mixed $value
     * @param bool $strict = true allows only explicit values, empty string and null (remains null)
     * @param bool $paranoid = false Throws exception if some value is lost on cast due to rounding on cast
     * @return float|null
     * @throws \Granam\Float\Tools\Exceptions\PositiveFloatCanNotBeNegative
     * @throws \Granam\Float\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Float\Tools\Exceptions\ValueLostOnCast
     */
    public static function toPositiveFloatOrNull($value, bool $strict = true, bool $paranoid = false): ?float
    {
        if ($value === null) {
            return null;
        }

        return static::toPositiveFloat($value, $strict, $paranoid);
    }

    /**
     * @param mixed $value
     * @param bool $strict = true allows only explicit values, not null and empty string
     * @param bool $paranoid = false Throws exception if some value is lost on cast due to rounding on cast
     * @return float
     * @throws \Granam\Float\Tools\Exceptions\PositiveFloatCanNotBeNegative
     * @throws \Granam\Float\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Float\Tools\Exceptions\ValueLostOnCast
     */
    public static function toPositiveFloat($value, bool $strict = true, bool $paranoid = false): float
    {
        $floatValue = static::toFloat($value, $strict, $paranoid);
        if ($floatValue < 0) {
            throw new Exceptions\PositiveFloatCanNotBeNegative(
                'Expected zero or higher number, got ' . ValueDescriber::describe($value)
            );
        }

        return $floatValue;
    }

    /**
     * @param mixed $value
     * @param bool $strict = true allows only explicit values, empty string and null (remains null)
     * @param bool $paranoid = false Throws exception if some value is lost on cast due to rounding on cast
     * @return float|null
     * @throws \Granam\Float\Tools\Exceptions\NegativeFloatCanNotBePositive
     * @throws \Granam\Float\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Float\Tools\Exceptions\ValueLostOnCast
     */
    public static function toNegativeFloatOrNull($value, bool $strict = true, bool $paranoid = false): ?float
    {
        if ($value === null) {
            return null;
        }

        return static::toNegativeFloat($value, $strict, $paranoid);
    }

    /**
     * @param mixed $value
     * @param bool $strict = true allows only explicit values, not null and empty string
     * @param bool $paranoid = false Throws exception if some value is lost on cast due to rounding on cast
     * @return float
     * @throws \Granam\Float\Tools\Exceptions\NegativeFloatCanNotBePositive
     * @throws \Granam\Float\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Float\Tools\Exceptions\ValueLostOnCast
     */
    public static function toNegativeFloat($value, bool $strict = true, bool $paranoid = false): float
    {
        $floatValue = static::toFloat($value, $strict, $paranoid);
        if ($floatValue > 0) {
            throw new Exceptions\NegativeFloatCanNotBePositive(
                'Expected zero or lesser number, got ' . ValueDescriber::describe($value)
            );
        }

        return $floatValue;
    }
}