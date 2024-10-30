# About
App created to request data from CE API and display content on Frontend and on a console command as requested

The application is developed using docker and Laravel Sail. 

To run the application, first you need to fill `CE_BASE_URL` and `CE_APIKEY` in the .env file

In order to create the file you can use the following command:
`cp .env.example .env`

If you have docker, you can run the application by installing the dependencies and executing it through sail.

`composer install`

`./vendor/bin/sail up`

The app should be available on your http://localhost and also you can access the command by executing `./vendor/bin/sail artisan ce:interactive`