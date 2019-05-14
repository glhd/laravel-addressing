# Laravel Addressing

[![Build Status](https://travis-ci.org/glhd/laravel-addressing.svg)](https://travis-ci.org/glhd/laravel-addressing) [![Coverage Status](https://coveralls.io/repos/github/glhd/laravel-addressing/badge.svg?branch=master)](https://coveralls.io/github/glhd/laravel-addressing?branch=master) [![Latest Stable Version](https://poser.pugx.org/galahad/laravel-addressing/v/stable)](https://packagist.org/packages/galahad/laravel-addressing) [![License](https://poser.pugx.org/galahad/laravel-addressing/license)](https://packagist.org/packages/galahad/laravel-addressing)

> Laravel package providing addressing functionality based on [`commerceguys/addressing`](https://github.com/commerceguys/addressing)

## Installation

First, install the composer package:

```
composer require galahad/laravel-addressing
```

## Basic Usage

### Country

```php
$country = Addressing::country('US');
echo $country->getName(); // "United States"
echo $country->getCountryCode(); // "US"
```

### Administrative Area (typically states or provinces)

```php
$usa = Addressing::country('US');

echo $usa->administrativeArea('AL')->getName(); // "Alabama"
echo $usa->administrativeArea('AL')->getCode(); // "AL"

typeof $usa->administrativeAreas() // AdministrativeAreaCollection
```

## Validators

You can use some custom validators in your Laravel app:

### Countries

You can use `country`, `country_code`, or `country_name` to validate country input:

```php
$this->validate($request, [
    'country' => 'required|country_code', // Must be a 2-letter ISO code, such as "US"
]);

$this->validate($request, [
    'country' => 'required|country_name', // Must be the full country name, such as "United States"
]);

$this->validate($request, [
    'country' => 'required|country', // Must be the full country name or 2-letter ISO code
]);
```

### Administrative Areas

You can use `administrative_area`, `administrative_area_code`, or `administrative_area_name` to validate administrative area input:

```php
// "country_field" is the form input that represents the country to validate against

$this->validate($request, [
    'state' => 'required|administrative_area_code:name_of_country_field',
]);

$this->validate($request, [
    'state' => 'required|administrative_area_name:country_field',
]);

$this->validate($request, [
    'state' => 'required|administrative_area:country_field',
]);
```

### Postal Code

You can use `postal_code` to validate the zip/postal code:

```php
$this->validate($request, [
    'postal_code' => 'required|postal_code:country_field,administrative_area_field',
]);
```

## HTTP Endpoints

Laravel Addressing publishes two routes by default, which can be disabled in the config file.
The prefix (`/galahad/addressing`) can also be configured.

#### GET /galahad/addressing/countries
```json
{
    "label": "Countries",
    "options": {
        "AF": "Afghanistan",
        "..": "...",
        "ZW": "Zimbabwe"
    }
}
```

#### GET /galahad/addressing/us/administrative-areas
```json
{
     "label": "States",
     "country_code": "US",
     "options": {
        "AL": "Alabama",
        "**": "*******",
        "WY": "Wyoming"
     }
}
```

## Changelog

### 1.0.0

This is the first stable release, with lots of breaking changes since 0.5.*

 - Minimum supported Laravel version is now `5.7` and the minimum supported PHP version is now `7.1.3`
 - `Galahad\LaravelAddressing\ServiceProvider` has been moved to `Galahad\LaravelAddressing\Support\AddressingServiceProvider`, so if you were manually registering the service provider, please update your `app.php` config file. 
 - `Galahad\LaravelAddressing\Facades\Addressing` has been moved to `Galahad\LaravelAddressing\Support\Facades\Addressing`, so if you were manually registering the service provider, please update your `app.php` config file.
 - The previously-deprecated `Galahad\LaravelAddressing\AddressFacade` has been removed 
 - All custom repository classes (`AddressFormatRepository`, `AdministrativeAreaRepository`, `CountryRepository`) have been removed. Instead, countries are accessed via the facade or `LaravelAddressing` class, and everything else is loaded via its parent.
 - Most custom methods have been removed from `CountryCollection` and `AdministrativeAreaCollection` (`getCountryCode()`, etc) in favor of just calling `getCountry()` on the collection and then accessing the Country entity directly.
 - `LaravelAddressing::getCountryList()` has been removed in favor of `countries()->toSelectArray()`
 - `Country::getAdministrativeAreasList()` has been removed in favor of `administrativeAreas()->toSelectArray()`
 - `Entity\Country` no longer extends `CommerceGuys\Addressing\Country` (which is now a `final` class), and instead provides a similar/decorated API
 - `Entity\AdministrativeArea` no longer extends `CommerceGuys\Addressing\Subdivision\Subdivision`, and instead extends `Entity\Subdivision` and provides a similar/decorated API
 - Administrative areas are no longer keyed by compound codes (i.e. `US-PA`) and instead by their country-specific codes (i.e. `PA`)
 - `Galahad\LaravelAddressing\Controller` has been split up into separate controllers. If you're extending this, please see the `Support/Http/` directory.
 - `$country->getPostalCodePattern()` has been removed in favor of `$country->addressFormat()->getPostalCodePattern()`
 - All validation logic has been refactored. The API is the same as long as you were using string-based validations (i.e. `'country_input' => 'country_code'`). If not, see `src/Support/Validation/` for details.
 - The `/{country}/administrative-areas` HTTP endpoint no longer returns an `expected_length` value and `country` has been renamed to `country_code`
 - The config `addressing.route.prefix` has been renamed `addressing.routes.prefix` and `addressing.routes.enabled` has been added
 - The `UnknownCountryException` is no longer thrown, and `NULL` is returned instead  

### Thanks!

Special thanks to [Commerce Guys](https://github.com/commerceguys) for their amazing 
[addressing](https://github.com/commerceguys/addressing) and [intl](https://github.com/commerceguys/intl) packages, 
which this project relies heavily on.
