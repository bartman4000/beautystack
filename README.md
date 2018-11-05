# BeautyStack Technical Exercise

## Prepare

Project is based on sqlite database so you need appropriate packages installed in your system (i.e. **pdo_sqlite** on Linux.)
Database file is located at **var/beautystack.db**

```
php bin/console doctrine:fixtures:load
```

## Build

```
composer install
```

## Test

```
./vendor/bin/phpunit
```

## Run

1. create vhost pointing to ***/public*** directory as DocumentRoot

OR

2. Move into your new project and start the server:
```
php bin/console server:run
``` 

As it is Symfony based project you will find more details here: https://symfony.com/doc/current/setup.html
