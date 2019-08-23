<?php declare(strict_types=1);

namespace Granam\Tests\Float;

use Granam\Float\FloatInterface;
use Granam\Number\NumberInterface;
use PHPUnit\Framework\TestCase;

class FloatInterfaceTest extends TestCase
{

    /**
     * @test
     */
    public function inherits_from_scalar_interface(): void
    {
        self::assertTrue(\is_a(
            FloatInterface::class,
            NumberInterface::class,
            true /* accept class name instead of instance */
        ));
    }
}