# Prerequisites

- Composer 2
- Xampp/Wamp ([Xampp](https://www.apachefriends.org/download.html) or Laragon
- PhpStorm or equivalent IDE (PhpStorm Preferred)
- 


## Installation

- Ensure the extracted folder contains the files as you open the extracted folder
- Ensure Composer is installed in your local environment
- Move the extracted folder to `htdocs` if using XAMPP or `www` if using WAMP/Laragon respectively and rename the folder (Eg: LFilamentTest)
- `cd` or navigate to the extracted folder in `/laragon/www/LFilamentTest`
- Open up a terminal or git bash and follow the below-mentioned commands

Install the packages to setup the application
```bash
composer install
```

All system configurations are managed by a file called `.env`, a file contains all the Environment Variables used in the system.

### Configuration

| Config              | Value                                                                                                                                 |
|---------------------|:--------------------------------------------------------------------------------------------------------------------------------------|
| `SQ_CHECK_BASE_URL`         | https://extranet.asmorphic.com/api/                                                                                                    |
| `SQ_CHECK_USERNAME`         | project-test@projecttest.com.au                                                                                                                      |
| `SQ_CHECK_PASSWORD`     | oxhyV9NzkZ^02MEB                                                                           |

After completing the above steps and configuring, DO NOT FORGET to restart your server.

```bash
php artisan optimize
```

## Finishing Up

If all the above configurations are correct, you may proceed to import the tables and fill (seed) the database by using this command

```bash
php artisan migrate --seed
```

## View Results

Enter this command and navigate to the given link. You should see the web application. Proceed to `/admin` to access the admin panel. Make sure you have a dedicated queue service running to handle the background jobs.

```bash
php artisan serve
```

## Credentials

By Default, A admin role is seeded to the database and many users with roles are created.

| User Role    | User email        | Password |
|--------------|-------------------|----------|
| Admin         | admin@example.com | password |


## Special Note

Provided API credentials did not succeed in the https://extranet.asmorphic.com/portal/ for finding the address or service qualification, hence direct NBN api calls have been integrated as a backup in the system (currently working via the NBN Direct api). 

## Demo

https://lfilamentest-main-dbqqui.laravel.cloud/admin
