## Strava Login and Calls

This package helps you to easily login your Strava account, and access the API. To use this package you will need to make a Strava app for more info checkout the documentation of the Strava API
[https://strava.github.io/api/](https://strava.github.io/api/)


## Installation

Require this package with composer. It is recommended to only require the package for development.

```shell
composer require KaiBotan/strava-login
```

Laravel 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

Don't forget to edit your .env file with your Strava app values.
```php
STRAVA_KEY=yourkeyfortheservice
STRAVA_SECRET=yoursecretfortheservice
STRAVA_REDIRECT_URI=https://example.com/login
```

### Laravel 5.5+:

If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php

```php
KjellKnapen\Strava\StravaServiceProvider::class,
```

If you want to use the facade to log messages, add this to your facades in app.php:

```php
'Strava' => KjellKnapen\Strava\StravaFacade::class,
```

## Usage

### Login user

```php
Strava::redirect(); //redirects user to Strava to login
```

You will then be redirected to the url you put in your .env file. Let's say its https://example.com/login
The url will have code you can use to send with the tokenexchange and get the user in return.

```php
$code = request()->code;

// Send code to strava to request token en get user
$result = Strava::tokenExchange($code);
```

now you can go and save the user.

### Post

The post method takes 2 variables, $url & $config. The url will be the api url you need to post to, like https://www.strava.com/api/v3/activities to upload a activity.
If we look at the documentation we see we need to send some headers and fields with the request, so our code would look something like this.

```php
$url = 'https://www.strava.com/api/v3/activities';

// the token for the header was given to you when Strava returned the user. Make sure you save it in the database per user.
$config = [
    'headers' => [
        'Authorization' => 'Bearer 83ebeabdec09f6670863766f792ead24d61fe3f9'
    ],
    'form_params' => [
        "name" => "Most Epic Ride EVER!!!"
        "elapsed_time" => 18373
        "distance" => 1557840
        "start_date_local" => "2013-10-23T10:02:13Z"
        "type" => "Ride"
    ]
];
$res = Strava::post($url, $config);

return $res;
```


### Get

The get method is similar to the post method and takes 2 variables, $url & $config. The url will be the api url you need to get, like https://www.strava.com/api/v3/athlete/activities to upload a activity.
For the get method we wil only need to put a header in our config for authentification

```php
$url = 'https://www.strava.com/api/v3/athlete/activities';

// the token for the header was given to you when Strava returned the user. Make sure you save it in the database per user.
$config = [
    'headers' => [
        'Authorization' => 'Bearer 83ebeabdec09f6670863766f792ead24d61fe3f9'
    ],
];
$res = Strava::get($url, $config);

return $res;
```

If there are any questions be sure to ask. More options like PUT will be added in the future

