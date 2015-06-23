# Converter and object wrapper for float value

[![Build Status](https://travis-ci.org/jaroslavtyc/granam-float.svg?branch=master)](https://travis-ci.org/jaroslavtyc/granam-float)

Note: requires PHP 5.4+

```php
<?php
use Granam\Float\Float;
use Granam\Float\Exceptions\WrongParameterType;

$float = new Float(123.456);

// double(123.456)
var_dump($float->getValue());
// string(7) "123.456"
var_dump((string)$float);

$float = new Float(null);
// double(0)
var_dump($float->getValue());
// string(0)
var_dump((string)$float);

$float = new Float($withTooLongDecimal = '123456.999999999999999999999999999999999999');
// double 123457
var_dump($float->getValue());

try {
  new Float('123.999999999999999999999999999999', true /* paranoid to rounding */);
} catch (WrongParameterType $floatException) {
  // Something get wrong: Some value has been lost on cast. Given string-number '123456.999999999999999999999999999999999999' results into float 123457
  die('Something get wrong: ' . $floatException->getMessage());
}

```
