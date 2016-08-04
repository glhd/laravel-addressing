# Laravel Addressing

> Laravel package providing addressing functionality

## Installation

First, install the composer package:

```
composer require galahad/laravel-addressing
```

In `config/app.php` add the Service Provider:

```php
'providers' => [
    // ... 
    Galahad\LaravelAddressing\ServiceProvider::class
],
```

And add the `Addressing` alias in the same file:

```php
'aliases' => [
    // ...
    'Addressing' => Galahad\LaravelAddressing\AddressFacade::class
],
```

## Basic Usage

### Country

```php
$country = Addressing::country('US');
echo $country->name; // United States
```

### Administrative Areas (States)

```php
echo Addressing::country('US')->state('AL')->name; // Alabama
```

```php
$states = Addressing::country('BR')->states();
foreach ($states as $code => $name) {
    echo "[$code]: $name\n";
}
```

### Cities

```php
$cities = Addressing::country('BR')->state('MG')->cities();
foreach ($cities as $city) {
    echo $city->name;
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
    "status": 200,
    "options": {
        "AF": "Afghanistan",
        "**": "*******",
        "ZW": "Zimbabwe"
    }
}
// If error
{
    "error": true,
    "status": 500,
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
     },
     "status": 200
}
```

### Setting custom Locales

You can get the countries list using a custom locale:

```
GET /galahad/addressing/countries?locale=pt
```