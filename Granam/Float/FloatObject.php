<?php
namespace Granam\Float;

use Granam\Float\Tools\ToFloat;
use Granam\Number\NumberObject;

class FloatObject extends NumberObject implements FloatInterface
{

    /**
     * @param mixed $value
     * @param bool $strict = true allows only explicit values, not null and empty string
     * @param bool $paranoid Throws exception if some value is lost on cast because of rounding
     */
    public function __construct($value, $strict = true, $paranoid = false)
    {
        parent::__construct(ToFloat::toFloat($value, $strict, $paranoid));
    }

}
