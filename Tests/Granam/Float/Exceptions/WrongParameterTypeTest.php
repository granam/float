<?php
namespace Granam\Float\Exceptions;

class WrongParameterTypeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @expectedException \Granam\Float\Exceptions\WrongParameterType
     */
    public function can_be_thrown()
    {
        throw new WrongParameterType;
    }

    /**
     * @test
     * @expectedException \Granam\Float\Exceptions\Runtime
     */
    public function is_based_on_local_runtime_exception()
    {
        throw new WrongParameterType;
    }
}
