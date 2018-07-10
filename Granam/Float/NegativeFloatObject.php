<?php
declare(strict_types=1);

namespace Granam\Float;

use Granam\Float\Tools\ToFloat;
use Granam\Number\NegativeNumberObject;

class NegativeFloatObject extends NegativeNumberObject implements NegativeFloat
{

    /**
     * @param mixed $value
     * @param bool $strict = true allows only explicit values, not null and empty string
     * @param bool $paranoid Throws exception if some value is lost on cast because of rounding
     * @throws \Granam\Float\Tools\Exceptions\NegativeFloatCanNotBePositive
     * @throws \Granam\Float\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Float\Tools\Exceptions\ValueLostOnCast
     */
    public function __construct($value, bool $strict = true, bool $paranoid = false)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        parent::__construct(ToFloat::toNegativeFloat($value, $strict, $paranoid));
    }

    public function getValue(): float
    {
        return parent::getValue();
    }

}