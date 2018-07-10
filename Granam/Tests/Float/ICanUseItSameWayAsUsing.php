<?php
declare(strict_types=1);

namespace Granam\Tests\Float;

use Granam\Float\Tools\ToFloat;
use PHPUnit\Framework\TestCase;

abstract class ICanUseItSameWayAsUsing extends TestCase
{
    /**
     * @param string $toFloatMethod
     * @param string $floatClass
     * @throws \ReflectionException
     */
    protected function I_can_use_it_same_way_as_using(string $toFloatMethod, string $floatClass): void
    {
        $toFloatClassReflection = new \ReflectionClass(ToFloat::class);
        $toFloatParameters = $toFloatClassReflection->getMethod($toFloatMethod)->getParameters();
        $floatObjectReflection = new \ReflectionClass($floatClass);
        $floatConstructor = $floatObjectReflection->getConstructor()->getParameters();
        self::assertEquals(
            $this->extractParametersDetails($toFloatParameters),
            $this->extractParametersDetails($floatConstructor),
            ToFloat::class . "::$toFloatMethod has different parameters than $floatClass::__construct"
        );
    }

    /**
     * @param array|\ReflectionParameter[] $parameterReflections
     * @return array
     */
    private function extractParametersDetails(array $parameterReflections): array
    {
        $extracted = [];
        foreach ($parameterReflections as $parameterReflection) {
            $extractedParameter = [];
            foreach (\get_class_methods($parameterReflection) as $methodName) {
                if (\in_array($methodName, ['getName', 'isPassedByReference', 'canBePassedByValue', 'isArray',
                        'isCallable', 'allowsNull', 'getPosition', 'isOptional', 'isDefaultValueAvailable',
                        'getDefaultValue', 'isVariadic'], true)
                    && ($methodName !== 'getDefaultValue' || $parameterReflection->isDefaultValueAvailable())
                ) {
                    $extractedParameter[$methodName] = $parameterReflection->$methodName();
                }
            }
            $extracted[] = $extractedParameter;
        }

        return $extracted;
    }

    /**
     * @param string $sutClass
     * @param string $testedMethod
     * @throws \ReflectionException
     */
    protected function assertUsableWithJustValueParameter(string $sutClass, string $testedMethod): void
    {
        $classReflection = new \ReflectionClass($sutClass);
        $method = $classReflection->getMethod($testedMethod);
        self::assertSame(1, $method->getNumberOfRequiredParameters(), 'Only single required parameter expected');
    }
}