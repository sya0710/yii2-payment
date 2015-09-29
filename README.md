# yii2-payment
yii2 payment

## Installation
Add 

```php
"sya/yii2-payment": "dev-master"
```

to the require section of your composer.json file.

# Use
```php
use sya\payment\Payment;

$form->field($model, 'payment')->widget(Payment::className(), [];
```

## License
**yii2-ecommerce** is released under the MIT License. See the bundled LICENSE.md for details.
