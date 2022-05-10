yii2-delayed-post
==============

Test task from 4kSoft

Limitation
------------
```
PHP >= 7.4
MYSQL => 4.8
```
Installation
------------
```
git clone mledoshchuk/demo-delayed-post.git project

cd project

composer install
```
Configure db.php file
---------------------
```
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=your_host_name;dbname=your_db_name',
    'username' => 'your_username',
    'password' => 'your_pswd',
    'charset' => 'utf8',
];

```
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
