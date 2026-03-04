# Readme

Contents:

- Description
- Development goals
- Incoming task
- Install
- Frontend form
- Backend structure
- Extension
- Tests
- A similar example based on Symfony

## Description

Framework-independent API example based on Laravel.

## Development goals

Development goals – to demonstrate how applications can be built without being tied to a specific framework.

## Incoming task

[pdf](./docs/incoming-task.pdf)

## Install

1. Install composer `composer install`.
2. Create `.env` - make a copy from .env.example.
3. Docker install:

   ```bash
   vendor/bin/sail build
   vendor/bin/sail up -d
   ```

4. App install:

   ```bash
   vendor/bin/sail shell
   php artisan migrate --seed
   php artisan key:generate
   ```

5. Check - [localhost](http://localhost)

## Frontend form

Visit [home page](http://localhost) and use a form to check the api.

## Backend structure

```sheme
Request               User          Response
                   |        /\
Post Form          |        |       Json object (status & data)
multipart/form-data|        |
                   \/       |
                     Laravel
                   \/       /\             
                Http Controller
                   |        /\     
Calculate command  |        |       View Dto
                   |        |
                   \/       |
                Carrier Service
                   |        /\
Find via VO Slug   |        |       Carrier
                   \/       |
                Carrier Repository
                       /\
Use Mysql              |         
as data                |
container              |
                       \/   
                      Mysql
```

## Extension

You can extend the aplication by:

- adding a new carrier
- changing the storage

### Adding a new carrier

1. Implement a new calculate class in the [dir](./app/Application/CarrierService/ShippingCostCalculators/)
2. Add a new row to the `carriers` mysql table:
    - name
    - slug
    - classname (from #1)
    - created_at

### New Persistence

If you would like to use config, file storage, or another persistence method, you only need to replace the *repository* to extend the application.

The Carrier service depends on the repository interface.

1. Create a new repository
2. Register it the [app provider](./app/Providers/AppServiceProvider.php)

## Tests

All classes are covered by tests. You can use `php artisan test`  to run tests inside a container. Also check [test dir](./tests/).

## A similar example based on Symfony

You can check a similar example based on Symfony [here](https://github.com/Romchik38/php-framework-independent-api-example-based-on-symfony).

Differences:

| layer      | this app | symfony example |
|------------|----------|-----------------|
| controller | laravel  | symfony         |
| storage    | mysql    | config          |
| template   | blade    | twig            |
