# Cms build on follower/core framework 
## Installation

### Download

```
git clone https://github.com/follower90/framework-admin.git cms
cd cms
```

### Setup config.php

Write your database connect options

### Command line operations

```
composer install

./builder schema:update 'admin'
./builder schema:update 'app'


./builder schema:migrate 'admin'
./builder schema:migrate 'app'
```

### Run

Setup host as usual website on your local Apache/Nginx
Or just run this command in cms folder using built-in PHP web server.

```
php -S localhost:4000
```

Try http://localhost:4000/ to access web-site
Try http://localhost:4000/admin to login admin part

Default login/password: admin/1234

## Features

### Routing

Default routing for pages will work as:

```
yoursite.com/controller/action?params=params
```

Default routing for Api calls will work as:

```
yoursite.com/api.php?method=Controller.action?params=params
```

You will also get POST variables in your action arguments

Also possible to write aliasses for controller name or action name:

```php
    Router::alias('buildings', 'Catalog');
    Router::actionAlias('all', 'index');
```

Then /buildings/all url will equal to /catalog/index

### ORM/Mapper/AR

All information you can find here:
https://github.com/follower90/framework-core

Shortly about ORM:
```php
$obj = Orm::findOne('User', ['name'], ['test'], $params);
$obj->setValue('name', 'test');
Orm::save($obj);
```

Shortly about Mapper:
```php
$mapper = OrmMapper::create('User');
$mapper->setFields(['test', 'name', 'amount']);
  ->setFilter(['test', 'name', 'amount'], [1,2,3]);
  ->load();
$users  = $mapper->getCollection();
```

Shortly about Active Record:
```php
$users = User::all()->addFilter('type', $id)->load()->getCollection();
$user = User::find($id);
$user->name = 'Peter';
$user->save();
```

Shortly about QueryBuilder:
```php
$query = new QueryBuilder('User');
$query->setBaseAlias('pc')
  ->select('id', 'title', 'name')
  ->join('left', 'User_Catalog', 'pc', ['catalog', 'another.id'])
  ->where('somevalue', [124, 125])
  ->orderBy('id', 'asc')
  ->limit(20);

echo $query->composeSelectQuery();
```

Shortly about SQL helper:
```php
MySQL::insert($table, $params);
MySQL::update($table, $params, $conditions);
MySQL::delete($table, $conditions);
```

### Admin Forms for CRUD

Builder for admin pages forms.
Field is automatically mapped to object property and value will transfered to component as 'value' variable.
You can write any new form components.
 
```php
$this->buildForm('page', $page, [
    ['field' => 'name', 'name' => 'Name', 'type' => 'input'],
    ['field' => 'url', 'name' => 'Url', 'type' => 'input'],
    ['field' => 'body', 'name' => 'Text', 'type' => 'textinput'],
]);
```
 
All form elements are separated to components in templates/form/snippet/*

### Admin UI

All components and libs for Admin UI you can take here:
https://startbootstrap.com/template-overviews/sb-admin-2/

### builder

Builder supports
 * git composer for admin and core repositories
 * recreate db schema
 * create new object from class
 * run sql-migrations
 * launch unit tests

To run builder and see help just type in root:
```
./builder
```