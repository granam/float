<?php declare(strict_types=1);

namespace Granam\Float;

use Granam\Number\NumberInterface;

interface FloatInterface extends NumberInterface
{
    public function getValue(): float;
}