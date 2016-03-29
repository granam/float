<?php
namespace Granam\Tests\Float;

abstract class ICanUseItSameWayAsUsing extends \PHPUnit_Framework_TestCase
{
    protected function I_can_create_it_same_way_as_using()
    {
        $integerObjectReflection = new \ReflectionClass('\Granam\Float\FloatObject');
        $integerConstructor = $integerObjectReflection->getConstructor()->getParameters();
        $toFloatClassReflection = new \ReflectionClass('\Granam\Float\Tools\ToFloat');
        $toFloatParameters = $toFloatClassReflection->getMethod('toFloat')->getParameters();
        self::assertEquals($toFloatParameters, $integerConstructor);
        foreach ($integerConstructor as $index => $constructorParameter) {
            $toFloatParameter = $toFloatParameters[$index];
            self::assertEquals($toFloatParameter, $constructorParameter);
            self::assertSame($toFloatParameter->isOptional(), $constructorParameter->isOptional());
            self::assertSame($toFloatParameter->allowsNull(), $constructorParameter->allowsNull());
            self::assertSame($toFloatParameter->isDefaultValueAvailable(), $constructorParameter->isDefaultValueAvailable());
            if ($constructorParameter->isDefaultValueAvailable()) {
                self::assertSame($toFloatParameter->getDefaultValue(), $constructorParameter->getDefaultValue());
            }
            self::assertSame($toFloatParameter->getName(), $constructorParameter->getName());
        }
    }

    protected function assertUsableWithJustValueParameter($sutClass, $testedMethod)
    {
        $classReflection = new \ReflectionClass($sutClass);
        $method = $classReflection->getMethod($testedMethod);
        self::assertSame(1, $method->getNumberOfRequiredParameters(), 'Only single required parameter expected');
    }
}