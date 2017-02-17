<?php
namespace Granam\Tests\Float;

use Granam\Float\Tools\ToFloat;
use PHPUnit\Framework\TestCase;

abstract class ICanUseItSameWayAsUsing extends TestCase
{
    /**
     * @param string $toFloatMethod
     * @param string $floatClass
     */
    protected function I_can_use_it_same_way_as_using($toFloatMethod, $floatClass)
    {
        $toFloatClassReflection = new \ReflectionClass(ToFloat::class);
        $toFloatParameters = $toFloatClassReflection->getMethod($toFloatMethod)->getParameters();
        $floatObjectReflection = new \ReflectionClass($floatClass);
        $floatConstructor = $floatObjectReflection->getConstructor()->getParameters();
        self::assertEquals(
            $this->extractParametersDetails($toFloatParameters),
            $this->extractParametersDetails($floatConstructor)
        );
    }

    /**
     * @param array|\ReflectionParameter[] $parameterReflections
     * @return array
     */
    private function extractParametersDetails(array $parameterReflections)
    {
        $extracted = [];
        foreach ($parameterReflections as $parameterReflection) {
            $extractedParameter = [];
            foreach (get_class_methods($parameterReflection) as $methodName) {
                if (in_array($methodName, ['getName', 'isPassedByReference', 'canBePassedByValue', 'isArray',
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

    protected function assertUsableWithJustValueParameter($sutClass, $testedMethod)
    {
        $classReflection = new \ReflectionClass($sutClass);
        $method = $classReflection->getMethod($testedMethod);
        self::assertSame(1, $method->getNumberOfRequiredParameters(), 'Only single required parameter expected');
    }
}