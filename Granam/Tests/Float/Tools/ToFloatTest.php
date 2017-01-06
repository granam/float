<?php
namespace Granam\Tests\Float\Tools;

use Granam\Float\FloatObject;
use Granam\Float\NegativeFloatObject;
use Granam\Float\PositiveFloatObject;
use Granam\Tests\Float\ICanUseItSameWayAsUsing;

class ToFloatTest extends ICanUseItSameWayAsUsing
{
    /**
     * @test
     */
    public function I_can_use_it_just_with_value_parameter()
    {
        parent::assertUsableWithJustValueParameter('\Granam\Float\Tools\ToFloat', 'toFloat');
    }

    /**
     * @test
     */
    public function I_can_use_it_same_way_as_using_number_object()
    {
        $this->I_can_use_it_same_way_as_using('toFloat', FloatObject::class);
        $this->I_can_use_it_same_way_as_using('toPositiveFloat', PositiveFloatObject::class);
        $this->I_can_use_it_same_way_as_using('toNegativeFloat', NegativeFloatObject::class);
    }
}