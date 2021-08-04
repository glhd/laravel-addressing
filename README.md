# Laravel Addressing

<a href="https://codeclimate.com/github/glhd/laravel-addressing/test_coverage" target="_blank">
    <img src="https://api.codeclimate.com/v1/badges/f01ed69a607407fc9114/test_coverage" alt="Code coverage status" />
</a>
<a href="https://github.com/glhd/laravel-addressing/actions/workflows/phpunit.yml" target="_blank">
    <img src="https://github.com/glhd/laravel-addressing/actions/workflows/phpunit.yml/badge.svg" alt="Tests status" />
</a>
<a href="https://github.com/glhd/laravel-addressing/blob/main/LICENSE">
    <img src="https://poser.pugx.org/galahad/laravel-addressing/license" alt="MIT License" />
</a>
<a href="https://packagist.org/packages/galahad/laravel-addressing" target="_blank">
    <img src="https://poser.pugx.org/galahad/laravel-addressing/v/stable" alt="Latest stable version" />
</a>

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

#### GET /galahad/addressing/countries/us/administrative-areas
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

### Thanks!

Special thanks to [Commerce Guys](https://github.com/commerceguys) for their amazing 
[addressing](https://github.com/commerceguys/addressing) and [intl](https://github.com/commerceguys/intl) packages, 
which this project relies heavily on.
