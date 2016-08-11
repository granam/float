<?php
namespace Granam\Tests\Float\Tools;

use Granam\Float\FloatObject;
use Granam\Number\NumberObject;
use Granam\Tests\Exceptions\Tools\AbstractExceptionsHierarchyTest;

class ExceptionsHierarchyTest extends AbstractExceptionsHierarchyTest
{
    /**
     * @return string
     */
    protected function getTestedNamespace()
    {
        return str_replace('\Tests', '', __NAMESPACE__);
    }

    /**
     * @return string
     */
    protected function getRootNamespace()
    {
        $rootClassReflection = new \ReflectionClass(FloatObject::getClass());

        return $rootClassReflection->getNamespaceName();
    }

    /**
     * @return string
     */
    protected function getExternalRootNamespaces()
    {
        $numberClassReflection = new \ReflectionClass(NumberObject::getClass());

        return $numberClassReflection->getNamespaceName();
    }

}
