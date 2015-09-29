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

$form->field($model, 'payment')->widget(Payment::className(), []);

OR

Payment::widget();
```

## License
**yii2-payment** is released under the MIT License. See the bundled LICENSE.md for details.
