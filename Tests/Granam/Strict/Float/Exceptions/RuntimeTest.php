<?php
namespace Granam\Float\Exceptions;

class RuntimeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function exception_interface_exists()
    {
        $this->assertTrue(interface_exists('Granam\Float\Exceptions\Runtime'));
    }

    /**
     * @test
     */
    public function extends_generic_exception_label()
    {
        $this->assertTrue(is_a('Granam\Float\Exceptions\Runtime', 'Granam\Float\Exceptions\Exception', true));
    }
}
