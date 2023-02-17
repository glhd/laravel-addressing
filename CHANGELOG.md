# Changelog

Starting with version 3.0.0, all notable changes will be documented in this file following the [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) format. This project adheres
to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- Added Laravel 10 support

## [3.1.0] - 2022-02-18

### Changed

-   Added support for PHP 8 and Laravel 9

### Added

-   Add 'orFail' variants of country and administrative area methods
-   Added `Macroable` to entities

## [3.0.0]

### Changed

-   Dropped support for older PHP and Laravel versions
-   Switched to PHP 7.4 syntax (more usage of type hints)
-   Switched to GitHub actions for CI
-   Implemented Get a Changelog standard

### Added

-   Added support for accessing values as attributes (i.e. `$country->country_code` as well as `$country->getCountryCode()`)
-   Added additional tests

### Fixed

-   Updated the collection methods to support Laravel's new `pop($count)` method signature

## 2.2.1 and before

We introduced the Keep a Changelog format with version 3.0.0. For versions 2.2.1 and below, 
see the [Github Releases](https://github.com/glhd/laravel-addressing/releases) and the old
release notes below:

### 2.0.1

This release adds Laravel 7 support and also is more permissive in its validators:

-   If we don't have a known list of administrative areas for a country, we just allow any value
-   If a country does not require an administrative area, we allow an empty string
-   If a country does not require a postal code, we allow an empty string

(The 2.0.0 release had a bug that failed to allow admin areas when we don't have data.)

### 1.0.0

This is the first stable release, with lots of breaking changes since 0.5.\*

-   Minimum supported Laravel version is now `5.7` and the minimum supported PHP version is now `7.1.3`
-   `Galahad\LaravelAddressing\ServiceProvider` has been moved to `Galahad\LaravelAddressing\Support\AddressingServiceProvider`, so if you were manually registering the service provider, please update
    your `app.php` config file.
-   `Galahad\LaravelAddressing\Facades\Addressing` has been moved to `Galahad\LaravelAddressing\Support\Facades\Addressing`, so if you were manually registering the service provider, please update
    your `app.php` config file.
-   The previously-deprecated `Galahad\LaravelAddressing\AddressFacade` has been removed
-   All custom repository classes (`AddressFormatRepository`, `AdministrativeAreaRepository`, `CountryRepository`) have been removed. Instead, countries are accessed via the facade
    or `LaravelAddressing` class, and everything else is loaded via its parent.
-   Most custom methods have been removed from `CountryCollection` and `AdministrativeAreaCollection` (`getCountryCode()`, etc) in favor of just calling `getCountry()` on the collection and then
    accessing the Country entity directly.
-   `LaravelAddressing::getCountryList()` has been removed in favor of `countries()->toSelectArray()`
-   `Country::getAdministrativeAreasList()` has been removed in favor of `administrativeAreas()->toSelectArray()`
-   `Entity\Country` no longer extends `CommerceGuys\Addressing\Country` (which is now a `final` class), and instead provides a similar/decorated API
-   `Entity\AdministrativeArea` no longer extends `CommerceGuys\Addressing\Subdivision\Subdivision`, and instead extends `Entity\Subdivision` and provides a similar/decorated API
-   Administrative areas are no longer keyed by compound codes (i.e. `US-PA`) and instead by their country-specific codes (i.e. `PA`)
-   `Galahad\LaravelAddressing\Controller` has been split up into separate controllers. If you're extending this, please see the `Support/Http/` directory.
-   `$country->getPostalCodePattern()` has been removed in favor of `$country->addressFormat()->getPostalCodePattern()`
-   All validation logic has been refactored. The API is the same as long as you were using string-based validations (i.e. `'country_input' => 'country_code'`). If not, see `src/Support/Validation/` for
    details.
-   The `/{country}/administrative-areas` HTTP endpoint no longer returns an `expected_length` value and `country` has been renamed to `country_code`
-   The config `addressing.route.prefix` has been renamed `addressing.routes.prefix` and `addressing.routes.enabled` has been added
-   The `UnknownCountryException` is no longer thrown, and `NULL` is returned instead

[Unreleased]: https://github.com/glhd/laravel-addressing/compare/3.1.0...HEAD

[3.1.0]: https://github.com/glhd/laravel-addressing/compare/3.0.0...3.1.0

[3.0.0]: https://github.com/glhd/laravel-addressing/compare/2.2.1...3.0.0

## Keep a Changelog Format

-   `Added` for new features
-   `Changed` for changes in existing functionality
-   `Deprecated` for soon-to-be removed features
-   `Removed` for now removed features
-   `Fixed` for any bug fixes
-   `Security` in case of vulnerabilities
