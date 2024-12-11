<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Setting up the tennis game project

This is a Laravel implementation on a tenning game

## Requirements
- PHP 8.3.12
- Mysql
- npm

## Running The app

In you terminal run the below commands
> cd tennis_match

> cp .env.example .env

Ensure that the database settings in your .env file match those of your local db

```text
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tennis_match
DB_USERNAME=root
DB_PASSWORD=
```


> npm install

> composer install

> php artisan migrate

> php artisan db:seed

In one terminal window run
> npm run dev

This needs to be run for the duration of you running the app

While the above is running, run
> php artisan serv

to view and run the app on a browser

Tests for the GameService located under tests/Feature/GameTest.php

Thank you for checking this out!! 😅
