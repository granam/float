<?php
namespace Granam\Float\Exceptions;

class WrongParameterTypeTest extends RuntimeTest {

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
     * @expectedException \Granam\Float\Exceptions\Logic
     */
    public function is_based_on_local_logic_exception()
    {
        throw new WrongParameterType;
    }
}
