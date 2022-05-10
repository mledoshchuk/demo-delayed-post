yii2-delayed-post
==============

Test task from 4kSoft

Limitation
------------

requires PHP >= 7.4

Installation
------------
```
git clone mledoshchuk/demo-delayed-post.git project

cd project

composer install


Updating database schema
------------------------

Run `yii migrate` command in command line:

```
php yii migrate/up
```

Starting the queue
-------------------------

```
yii queue/listen
```
