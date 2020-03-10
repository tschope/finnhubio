# Finnhub.io PHP API Client Wrapper for Laravel

[![Latest Stable Version](https://poser.pugx.org/tschope/finnhubio/v/stable)](https://packagist.org/packages/tschope/finnhubio) [![Total Downloads](https://poser.pugx.org/tschope/finnhubio/downloads)](https://packagist.org/packages/tschope/finnhubio)

This is a wrapper for the [https://finnhub.io/docs/api](https://finnhub.io/docs/api)

## Installation
1. `composer require tschope/finnhubio`
2. Get a Finnhub API Key from the Intergrations page of your Finnhub account.
3. Laravel 6.x or earlier, in your `config/app.php` file:
    - Add `Tschope\Finnhubio\FinnhubioServiceProvider::class` to your providers array.
4. `php artisan vendor:publish --provider="Tschope\Finnhubio\FinnhubioServiceProvider" --tag="config"` will create a `config/finnhubio.php` file.

## Usage
```php
Route::get('/', function () {
    $stock = new \Tschope\Finnhubio\Stock();
    return $stock->quote('MGLU3.SA');
});
```

For more info on using the actual API see the main repo [https://finnhub.io/docs/api](https://finnhub.io/docs/api)
