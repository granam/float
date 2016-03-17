<?php
namespace Granam\Tests\Float\Tools;

use Granam\Tests\Exceptions\Tools\AbstractExceptionsHierarchyTest;

class ExceptionsHierarchyTest extends AbstractExceptionsHierarchyTest
{
    protected function getTestedNamespace()
    {
        return str_replace('\Tests', '', __NAMESPACE__);
    }

    protected function getRootNamespace()
    {
        $rootClassReflection = new \ReflectionClass('\Granam\Float\FloatObject');

        return $rootClassReflection->getNamespaceName();
    }

}
