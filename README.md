yii2-delayed-post
==============

Test task from 4kSoft

Limitation
------------

requires PHP >= 7.4

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist tigrov/yii2-mailqueue "~1.1.1"
```

or add

```
"tigrov/yii2-mailqueue": "~1.1.1"
```

to the require section of your `composer.json` file.

 
Configuration
-------------
Once the extension is installed, add following code to your application configuration:

```php
return [
    // ...
    'components' => [
        'mailer' => [
            'class' => 'tigrov\mailqueue\Mailer',
            'table' => '{{%mail_queue}}',
            'maxAttempts' => 5,
            'attemptIntervals' => [0, 'PT10M', 'PT1H', 'PT6H'],
            'removeFailed' => true,
            'maxPerPeriod' => 10,
            'periodSeconds' => 1,
        ],
    ],
    // ...
];
```


Updating database schema
------------------------

Run `yii migrate` command in command line:

```
php yii migrate/up --migrationPath=@vendor/---/yii2-mailqueue/src/migrations/
```

Starting the queue
-------------------------

```
yii queue/listen
```
