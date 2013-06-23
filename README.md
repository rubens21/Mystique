# Credit Card Number Generator

[![Build Status](https://secure.travis-ci.org/gxela/creditcard-number-generator.png?branch=master)](http://travis-ci.org/gxela/creditcard-number-generator)

## Install

The recommended way to install gxela/creditcard-number-generator is [through composer](http://getcomposer.org).

```JSON
{
    "require": {
        "gxela/creditcard-number-generator": "0.1.*"
    }
}
```

## Example

```php
<?php

$visa = App::make('credit_card_generator.visa');
echo $visa;
```

## License

MIT, see LICENSE.
