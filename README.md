## Requirements

- PHP >=8.0
- Mysql >=s8.0

### Project setup

```
$ git clone https://github.com/AxelBuob/api.git
```

```
$ cd api
```

### Config

```
###> symfony/framework-bundle ###
APP_ENV=dev
APP_SECRET=91ab239fd73cc9062275e97c205c1586
###< symfony/framework-bundle ###

###> doctrine/doctrine-bundle ###
# Format described at https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url
# IMPORTANT: You MUST configure your server version, either here or in config/packages/doctrine.yaml
#
# DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
DATABASE_URL="mysql://root:password@127.0.0.1:3306/api?serverVersion=5.7&charset=utf8mb4"
# DATABASE_URL="postgresql://symfony:ChangeMe@127.0.0.1:5432/app?serverVersion=13&charset=utf8"
###< doctrine/doctrine-bundle ###

###> nelmio/cors-bundle ###
CORS_ALLOW_ORIGIN='^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$'
###< nelmio/cors-bundle ###

###> lexik/jwt-authentication-bundle ###
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=b5231cc371cb2c8b56391c0532b684e9
###< lexik/jwt-authentication-bundle ###
```


```
$ composer install
$ php bin/console lexik:jwt:generate-keypair
```

### DB

```
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:update --force
```

### Load Data fixtures

```
php bin/console doctrine:fixtures:load --no-interaction
```

### Run

```
$ symfony serve
or
$ php -S localhost:8000
```