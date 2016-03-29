<?php
namespace Granam\Tests\Float\Tools;

class ToFloatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function I_can_use_it_just_with_value_parameter()
    {
        $reflection = new \ReflectionClass('\Granam\Float\Tools\ToFloat');
        $toNumber = $reflection->getMethod('toFloat');
        self::assertSame(1, $toNumber->getNumberOfRequiredParameters());
    }
}