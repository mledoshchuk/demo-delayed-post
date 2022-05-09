yii2-delayed-post
==============

Test task from 4kSoft

Limitation
------------

requires PHP >= 7.4

Installation
------------


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
