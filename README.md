yii2-locale
===========

Locale class represents the data relevant to a locale such as countries, languages, and orientation.

This class uses and depend on the PHP intl extension.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist ashrafakl/yii2-locale "~1.0.1"
```

or add

```
"ashrafakl/yii2-locale": "~1.0.1"
```

to the require section of your `composer.json` file.

Usage
-----

Once the extension is installed then add this to your application configuration:

```php
<?php
return [
    // ...
    'components' => [
        // ...
        'locale' => [
            'class'=> 'ashrafakl\localization\Locale',
        ],
        // ...
    ]
];
```


Public methods
-------------------------------

| Name     | Description    |
| --------|---------|
| getCountries  | Get Countries list |
| getRelativePrimaryLanguages  | Get languages list relative to its locale |
| getPrimaryLanguages  | Get languages list |
| getOrientation  | Get characters orientation, which is either 'ltr' (left-to-right) or 'rtl' (right-to-left) |

Example
-------

To get orientaion use the following code 
```pho
<?= Yii::$app->locale->getOrientation() ?>
```
