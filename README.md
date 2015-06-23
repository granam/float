# Base value object with float only

[![Build Status](https://travis-ci.org/jaroslavtyc/granam-strict-float.svg?branch=master)](https://travis-ci.org/jaroslavtyc/granam-strict-float)

PHP does not provide scalar type hinting [yet](https://wiki.php.net/rfc/scalar_type_hints#proposed_php_version_s) (planned for PHP 7.0).

For that reason, if we want to be sure about scalar type, a type-checking class is the only chance.

Note: requires PHP 5.4+

```php
<?php
use Granam\Strict\Float\StrictFloat;
use Granam\Strict\Float\Exceptions\WrongParameterType;

$float = new StrictFloat(123.456);

// double(123.456)
var_dump($float->getValue());
// string(7) "123.456"
var_dump((string)$float);

$float = new StrictFloat(null, false /* explicitly non-strict*/);
// double(0)
var_dump($float->getValue());
// string(0)
var_dump((string)$float);

try {
  new StrictFloat(null);
} catch (WrongParameterType $floatException) {
  // Something get wrong: On strict mode expected float only, got NULL
  die('Something get wrong: ' . $floatException->getMessage());
}

```
