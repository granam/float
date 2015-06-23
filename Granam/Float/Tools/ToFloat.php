<?php
namespace Granam\Float\Tools;

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
        if (is_float($value) || is_bool($value) || is_null($value)) {
            // true = 1; false = 0; null = 0
            return floatval($value);
        }

        try {
            $stringValue = ToString::toString($value);
        } catch (\Granam\Scalar\Tools\Exceptions\WrongParameterType $exception) {
            throw new Exceptions\WrongParameterType($exception->getMessage(), $exception->getCode(), $exception);
        }

        $floatValue = floatval($stringValue); // note: '' = 0
        if ($paranoid) {
            self::checkIfNoValueHasBeenLostByCast($floatValue, $stringValue);
        }

        return $floatValue;
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
