# Laravel Addressing

[![Build Status](https://travis-ci.org/glhd/laravel-addressing.svg)](https://travis-ci.org/glhd/laravel-addressing)

> Laravel package providing addressing functionality

## Installation

First, install the composer package:

```
composer require galahad/laravel-addressing
```

## Basic Usage

## 1.0 Breaking Changes
 - Minimum supported Laravel version is now `5.7` and the minimum supported PHP version is now `7.1.3`
 - `Galahad\LaravelAddressing\ServiceProvider` has been moved to `Galahad\LaravelAddressing\Support\AddressingServiceProvider`, so if you were manually registering the service provider, please update your `app.php` config file. 
 - `Galahad\LaravelAddressing\Facades\Addressing` has been moved to `Galahad\LaravelAddressing\Support\Facades\Addressing`, so if you were manually registering the service provider, please update your `app.php` config file.
 - The previously-deprecated `Galahad\LaravelAddressing\AddressFacade` has been removed 
 - All custom repository classes have been removed. Instead, countries are accessed via the facade or `LaravelAddressing` class, and everything else is loaded via its parent.
 - Most custom methods have been removed from `CountryCollection` and `AdministrativeAreaCollection` (`getCountryCode()`, etc) in favor of just calling `getCountry()` on the collection and then accessing the Country entity directly.
 - `LaravelAddressing::getCountryList()` has been removed in favor of `countries()->toOptionsList()`
 - `Country::getAdministrativeAreasList()` has been removed in favor of `administrativeAreas()->toOptionsList()`
 - `Entity\Country` no longer extends `CommerceGuys\Addressing\Country` (which is now a `final` class), and instead provides a similar/decorated API
 - `Entity\AdministrativeArea` no longer extends `CommerceGuys\Addressing\Subdivision\Subdivision`, and instead extends `Entity\Subdivision` and provides a similar/decorated API
 - Administrative areas are no longer keyed by compound codes (i.e. `US-PA`) and instead by their country-specific codes (i.e. `PA`) 
 - Country::getPostalCodePattern -> Country::addressFormat::getPostalCodePattern
 - *List has been removed

### Country

```php
$country = Addressing::country('US');
echo $country->getName(); // United States
```

### Administrative Areas (States)

```php
echo Addressing::country('US')->administrativeArea('AL')->getName(); // Alabama
```

```php
$administrativeAreas = Addressing::country('BR')->administrativeAreas();
foreach ($administrativeAreas as $administrativeArea) {
    echo sprint("[%s]: %s\n", $administrativeArea->getCode(), $administrativeArea->getName());
}
```

## Validators

You can use some custom validators in your Laravel app:

### Countries

You can use `country_code` and `country_name` validators:

```php
$this->validate($request, [
    'country' => 'required|country_code',
]);

$this->validate($request, [
    'country' => 'required|country_name',
]);
```

### Administrative Areas (States)

You can use `administrative_area_code`, `administrative_area_name` or `administrative_area` (verifies both `code` and `name`):

```php
$this->validate($request, [
    'state' => 'required|administrative_area_code:country_field',
]);

$this->validate($request, [
    'state' => 'required|administrative_area_name:country_field',
]);

$this->validate($request, [
    'state' => 'required|administrative_area:country_field', // verifies first code and after name
]);
```

### Postal Code

You can check if the postal code starts with the correct pattern using `postal_code` validator:

```php
$this->validate($request, [
    'postal_code' => 'required|postal_code:country_field,administrative_area_field',
]);
```

## API

You can also get Countries and Administrative Areas (states) in `JSON` format:

```json
// GET /galahad/addressing/countries
{
    "label": "Countries",
    "options": {
        "AF": "Afghanistan",
        "**": "*******",
        "ZW": "Zimbabwe"
    }
}
// If error
{
    "error": true,
    "message": "Could not get countries"
}

// GET /galahad/addressing/US/adminstrative-areas
{
     "label": "State",
     "expected_length": 2,
     "country": "US",
     "options": {
        "AL": "Alabama",
        "**": "*******",
        "WY": "Wyoming"
     }
}
```

### Setting custom Locales

You can get the countries list using a custom locale:

```
GET /galahad/addressing/countries?locale=pt
```

### Changing the route group prefix

By default the routes returning the JSON responses are prefixed with `galahad/addressing`. If you would like to change this, you need to publish the configuration file using `php artisan vendor:publish --provider="Galahad\LaravelAddressing\ServiceProvider"`. This will create a config file (`addressing.php`) in your `config` directory with:

```php 
<?php

return [
    'route' => [
        'prefix' => 'countries' // change this to whatever you'd like
    ],
];
```


### Thanks!

Special thanks to [Commerce Guys](https://github.com/commerceguys) for their amazing [addressing](https://github.com/commerceguys/addressing) and [intl](https://github.com/commerceguys/intl) packages, which this project relies heavily on.
