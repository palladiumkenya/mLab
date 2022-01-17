<p align="center">
  <a href="https://mlab.palladiumkenya.co.ke">
    <img src="https://mlab.mhealthkenya.co.ke/assets/images/logo.png" alt="mLab">
  </a>
  </p>

# mLab Dashboard and API's

### Features

mLab has the following modules: <br>
Patient results: this module allows for client appointment management and client enrollment. <br>
Sub-functions in this module include: <br>
-Sample remote login: for allowing login of samples into the system for the samples being sent to the labs <br>
-HTS results transmission: for HIV results for non – conclusive tests <br>
-Client messaging: for consent and message of clients on results availability to enhance linkage to care <br>

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.8/installation#installation)

Alternative installation is possible without local dependencies relying on [Docker](#docker). 

Clone the repository

    git clone https://github.com/palladiumkenya/mLab.git

Switch to the repo folder

    cd mLab

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone https://github.com/mHealthKenya/mLab.git
    cd mLab
    composer install
    cp .env.example .env
    php artisan key:generate
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Dependencies

- [laravel-passport](https://github.com/laravel/passport) - For handling authentication
- [laravel-cors](https://github.com/barryvdh/laravel-cors) - For handling Cross-Origin Resource Sharing (CORS)
- [africastalking](https://github.com/AfricasTalkingLtd/africastalking-php) - For SMS

## Folders

- `app` - Contains all the Eloquent models
- `app/Http/Controllers` - Contains all the api controllers
- `app/Http/Middleware` - Contains the JWT auth middleware
- `app/Http/Controllers/VLResultsController.php` - Contains the functions implementing the vl and eid results module
- `app/Http/Controllers/HTSResultsController.php` - Contains the functions implementing the hts results module
- `app/Http/Controllers/RemoteLoginController.php` - Contains the functions implementing the sample remote login module
- `app/Http/Controllers/SendResultsController.php` - Contains the functions implementing the sending of results via the mobile application
- `app/Http/Controllers/TBResultsController.php` - Contains the functions implementing the TB results module
- `app/Http/Controllers/DataController.php` - Contains the functions and queries for the highcharts
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `routes/api` - Contains all the api routes
- `routes/web` - Contains all the dashboard routes
- `tests` - Contains all the application tests

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Testing API

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api

Request headers

| **Required** 	| **Key**              	| **Value**            	|
|----------	|------------------	|------------------	|
| Yes      	| Content-Type     	| application/json 	|
| Yes      	| X-Requested-With 	| XMLHttpRequest   	|
| Optional 	| Authorization    	| Token {JWT}      	|

Refer the [api specification](#api-specification) for more info.

----------
 
# Authentication
 
This applications uses Passport to handle authentication. The token is passed with each request using the `Authorization` header with `Token` scheme. The Passport authentication middleware handles the validation and authentication of the token. Please check the following sources to learn more about JWT.
 
- https://github.com/laravel/passport/

----------

# Cross-Origin Resource Sharing (CORS)
 
This applications has CORS enabled by default on all API endpoints. The default configuration allows requests from `http://localhost:3000` and `http://localhost:4200` to help speed up your frontend testing. The CORS allowed origins can be changed by setting them in the config file. Please check the following sources to learn more about CORS.
 
- https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS
- https://en.wikipedia.org/wiki/Cross-origin_resource_sharing
- https://www.w3.org/TR/cors
## Dependencies

- [laravel-cors](https://github.com/barryvdh/laravel-cors) - For handling Cross-Origin Resource Sharing (CORS)

## License

[![license](https://img.shields.io/github/license/mashape/apistatus.svg?style=for-the-badge)](#)

[![Open Source Love](https://badges.frapsoft.com/os/v2/open-source-200x33.png?v=103)](#)
