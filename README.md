# Cms build on follower/core framework 
## Installation

### download

```
git clone https://github.com/follower90/framework-admin.git cms
cd cms
```

### setup config.php

Write your database connect options

### command Line operation

```
composer install

./builder schema:update 'admin'
./builder schema:update 'app'


./builder schema:migrate 'app'
./builder schema:migrate 'app'
```

### Run

Setup host as usual website on your local Apache/Nginx
Or just run this command in cms folder using built-in PHP web server.

```
php -S localhost:4000
```