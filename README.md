<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Description

This is a Laravel API, with some features to manage a health application. In this app, you will find some functionalities such as options to manage Hospitals and Organs by the admins. Option to register patient profile, choose which patient type the person is (donor or recipient), which organs this person needs/is willing to donate, which hospitals she prefers and some filter options.

## Installation

To install all the packages used in this Laravel application you must Clone this repository and use these commands.

Inside the cloned repository project, run docker dependencies to get php, composer and laravel installations. (You must download and configure docker in your setup for this to work.
```bash
$ docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

```bash
$ duplicate the .env_example file and name it .env
```
## Creating an alias for sail

```bash
$ alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

## Running migrations

To create all the base tables you need, run the following command

```bash
$ sail artisan migrate
```

## Running seeds

This command, will run and create some fake registers inside the tables.

```bash
$ sail artisan db:seed
```

## Running the container

```bash
$ sail up
```

## Running the container (without alias)

```bash
$ ./vendor/bin/sail up
```

## Stopping the container

```bash
$ sail down
```

## Stopping the container (without alias)

```bash
$ ./vendor/bin/sail down
```

## Accessing the laravel container

```bash
$ docker exec -it organ-donation-app-laravel.test-1 bash
```


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
