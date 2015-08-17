<?php
namespace Granam\Float\Tools;

use Granam\Number\Tools\ToNumber;
use Granam\Scalar\Tools\ToString;

class ToFloat
{
    /**
     * @param $value
     * @param bool $paranoid Throws exception if some value is lost on cast due to rounding on cast
     * @return float
     */
    public static function toFloat($value, $paranoid = false)
    {
        // true = 1; false = 0; null = 0
        $value = self::convertToNumber($value, $paranoid);

        if (is_float($value)) {
            return floatval($value);
        }

        $stringValue = self::convertToString($value);
        $floatValue = floatval($stringValue); // note: '' = 0
        if ($paranoid) {
            self::checkIfNoValueHasBeenLostByCast($floatValue, $stringValue);
        }

        return $floatValue;
    }

    private static function convertToNumber($value, $paranoid)
    {
        try {
            return ToNumber::toNumber($value, $paranoid);
        } catch (\Granam\Number\Tools\Exceptions\WrongParameterType $exception) {
            throw new Exceptions\WrongParameterType($exception->getMessage(), $exception->getCode(), $exception);
        } catch (\Granam\Number\Tools\Exceptions\ValueLostOnCast $exception) {
            throw new Exceptions\ValueLostOnCast($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    private static function convertToString($value)
    {
        try {
            return ToString::toString($value);
        } catch (\Granam\Scalar\Tools\Exceptions\WrongParameterType $exception) {
            throw new Exceptions\WrongParameterType($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    private static function checkIfNoValueHasBeenLostByCast($floatValue, $stringValue)
    {
        preg_match('~^(?:\s*0*)(?<numericPart>\d+(\.([1-9]+|0+(?=[1-9]+))+)*)~', $stringValue, $numericParts);
        $numericPart = '0';
        if (isset($numericParts['numericPart'])) {
            $numericPart = $numericParts['numericPart'];
        }

        if ("$floatValue" !== $numericPart) { // some value has been lost
            throw new Exceptions\ValueLostOnCast(
                'Some value has been lost on cast. Given string-number ' . var_export($numericPart, true) . ' results into float ' . var_export($floatValue, true)
            );
        }
    }
}
