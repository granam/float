<?php
namespace Granam\Tests\Float\Tools;

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
    public function I_can_create_it_same_way_as_using_number_object()
    {
        parent::I_can_create_it_same_way_as_using();
    }
}