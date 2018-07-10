<?php
namespace Granam\Float;

use Granam\Number\NumberInterface;

interface FloatInterface extends NumberInterface
{
    /**
     * @return float
     */
    public function getValue(): float;
}