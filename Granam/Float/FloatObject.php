<?php
namespace Granam\Float;

use Granam\Float\Tools\ToFloat;
use Granam\Scalar\Scalar;

class FloatObject extends Scalar implements FloatInterface
{

    /**
     * @var float
     */
    protected $value;

    /**
     * @var  bool
     */
    protected $paranoid;

    /**
     * @param mixed $value
     * @param bool $paranoid Throws exception if some value is lost on cast because of rounding
     */
    public function __construct($value, $paranoid = false)
    {
        $this->paranoid = (bool)$paranoid;
        $this->value = ToFloat::toFloat($value, $this->paranoid);
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isParanoid()
    {
        return $this->paranoid;
    }

}
