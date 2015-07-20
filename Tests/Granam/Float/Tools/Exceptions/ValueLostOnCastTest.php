<?php
namespace Granam\Float\Tools\Exceptions;

class ValueLostOnCastTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @expectedException \Granam\Float\Tools\Exceptions\ValueLostOnCast
     */
    public function can_be_thrown()
    {
        throw new ValueLostOnCast;
    }

    /**
     * @test
     * @expectedException \Granam\Float\Exceptions\Runtime
     */
    public function is_based_on_local_runtime_exception()
    {
        throw new ValueLostOnCast;
    }
}
