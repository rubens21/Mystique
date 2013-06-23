Credit Card Number Generator Package for Laravel 4
==================================================

###usage

in app/config/app.php
```
'providers' => array(
    ...
    'Gxela\CreditcardNumberGenerator\CreditcardNumberGeneratorServiceProvider',
    ...
);
```

```
$visa = App::make('credit_card_generator.visa');
echo $visa;
```

creating object
```
$cc = new \Gxela\CreditcardNumberGenerator\CreditCardGenerator();
$number_of_cards = 2;
echo $cc->get_visa16($number_of_cards); //returns array with 2 credit card numbers in it
echo $cc->get_mastercard(); //return string credit card number
```

call static
```
echo \Gxela\CreditcardNumberGenerator\CreditCardGenerator::get_visa16();
```