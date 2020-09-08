# Laravel-Reddit-API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/codewizz/laravel-reddit-api.svg?style=flat-square)](https://packagist.org/packages/codewizz/laravel-reddit-api)
[![Total Downloads](https://img.shields.io/packagist/dt/codewizz/laravel-reddit-api.svg?style=flat-square)](https://packagist.org/packages/codewizz/laravel-reddit-api)

Using this package you can easily retrieve data from Reddit API.

Laravel wrapper for https://github.com/rotorcowboy/Phapper

Supports Laravel 5.x - 8.x.

Here are a few examples of the provided methods:
```php
use RedditAPI;

//fetch top Reddit posts
RedditAPI::getTop();

//fetch top picture posts of Margot Robbie, limit to 100
RedditAPI::search('Margot Robbie ', null, 'top', null, 'pics', 100);
```

## Install

This package can be installed through Composer.

``` bash
composer require codewizz/laravel-reddit-api
```

If you are using Laravel 5.5+, the service provider and alias will be registered automatically. You can proceed to "[Publish config](#publish-config)".

### Manually register services

You must install this service provider.

```php
// config/app.php
'providers' => [
    ...
    CodeWizz\RedditAPI\RedditAPIServiceProvider::class,
    ...
];
```

This package also comes with a facade, which provides an easy way to call the the class.

```php
// config/app.php
'aliases' => [
    ...
    'RedditAPI' => CodeWizz\RedditAPI\RedditAPIFacade::class,
    ...
];
```

### Publish config

You should publish the config file of this package with this command:

``` bash
php artisan vendor:publish --provider="CodeWizz\RedditAPI\RedditAPIServiceProvider"
```

The following config file will be published in `config/reddit-api.php`

```php
return [
    'endpoint_standard' => 'https://www.reddit.com',
    'endpoint_oauth' => 'https://oauth.reddit.com',
    
    'username' => env('REDDIT_USERNAME', ''),
    'password' => env('REDDIT_PASSWORD', ''),
    'app_id' => env('REDDIT_APP_ID', ''),
    'app_secret' => env('REDDIT_APP_SECRET', ''),
    
    'response_format' => 'STD', // STD | ARRAY
    
    'scopes' => 'save,modposts,identity,edit,flair,history,modconfig,modflair,modlog,modposts,modwiki,mysubreddits,privatemessages,read,report,submit,subscribe,vote,wikiedit,wikiread'
];
```


## About CodeWizz
CodeWizz is a web development agency based in Lithuania. You'll find more information [on our website](https://codewizz.com).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
