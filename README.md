# Cms build on follower/core framework 
## Installation

### Download

```
git clone https://github.com/follower90/framework-admin.git cms
cd cms
```

### Setup config.php

Write your database connect options

### Install composer requirements

```
composer install
```

### Create schema from objects

```
./builder schema:update 'admin'
./builder schema:update 'app'
```

### Apply migrate SQL scripts

```
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

### Api and Controllers

You will create new API endpoints and Contollers in these namespaces:
* \App\Api
* \App\Controller
* \Admin\Api
* \Admin\Controller

with method<ActionName> method.
It automatically will work at these routes:
```
yoursite.com/api.php?method=ControllerName.ActionName
yoursite.com/admin/api.php?method=ControllerName.ActionName

yoursite.com/admin/controllerName/actionName
yoursite.com/controllerName/ActionName
```
It automatically retrieve to method arguments:
* GET parameters
* POST parameters
* URI-parameters, splitted by slash

For example, `yoursite.com/admin/page/edit/2` will have key 'edit' with value 2 in `\Admin\Controller\Page.methodEdit`

### Snippets

You can use snippets (reusable html-components) in your admin templates.

Implement method that will return rendered HTML and just call it in *.phtml file:
```php
_snippet('snippetName', [$arg1, $arg2, ...]);
```

### Localization

In the templates you should pass all text labels to `__` method.

It will find and output translated value for current user language: 'site_language' in your `Config`

If translation is not existed in your database, it will output entered value and automatically added to translation without value.

Then you can go to /admin/translation and edit new value.

```php
<? __('catalog.Name'); ?>
```