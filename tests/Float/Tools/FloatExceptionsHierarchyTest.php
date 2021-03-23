<?php declare(strict_types=1);

namespace Granam\Tests\Float\Tools;

use Granam\Float\FloatObject;
use Granam\Number\NumberObject;
use Granam\Tests\ExceptionsHierarchy\Exceptions\AbstractExceptionsHierarchyTest;

class FloatExceptionsHierarchyTest extends AbstractExceptionsHierarchyTest
{
    protected function getTestedNamespace(): string
    {
        return \str_replace('\Tests', '', __NAMESPACE__);
    }

    protected function getRootNamespace(): string
    {
        $rootClassReflection = new \ReflectionClass(FloatObject::class);

        return $rootClassReflection->getNamespaceName();
    }

    protected function getExternalRootNamespaces(): array
    {
        $numberClassReflection = new \ReflectionClass(NumberObject::class);

        return [$numberClassReflection->getNamespaceName()];
    }

}
