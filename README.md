# Converter and object wrapper for float value

[![Build Status](https://travis-ci.org/jaroslavtyc/granam-float.svg?branch=master)](https://travis-ci.org/jaroslavtyc/granam-float)

## Hint
First of all, make sure you don't need just a [simple  built-in float validation](http://php.net/manual/en/function.filter-var.php).

```php
<?php
use Granam\Float\FloatObject;

$float = new FloatObject(123.456);

// double(123.456)
var_dump($float->getValue());
// string(7) "123.456"
var_dump((string)$float);

$float = new FloatObject(null);
// double(0)
var_dump($float->getValue());
// string(0)
var_dump((string)$float);

$float = new FloatObject($withTooLongDecimal = '123456.999999999999999999999999999999999999');
// double 123457
var_dump($float->getValue());

try {
  new FloatObject('123.999999999999999999999999999999', true /* paranoid to rounding */);
} catch (\Granam\Float\Tools\Exceptions\WrongParameterType $floatException) {
  // Something get wrong: Some value has been lost on cast. Given string-number '123456.999999999999999999999999999999999999' results into float 123457
  die('Something get wrong: ' . $floatException->getMessage());
}

```
