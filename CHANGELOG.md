# Changelog

Starting with version 3.0.0, all notable changes will be documented in this file following the [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) format. This project adheres
to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Changed

- Switched to PHP 7.4 syntax (more usage of types)
- Switched to GitHub actions for CI

### Added

- Added support for accessing values as attributes (i.e. `$country->country_code` as well as `$country->getCountryCode()`)
- Added additional tests

### Fixed

- Updated the collection methods to support Laravel's new `pop($count)` method signature

## 2.2.1 and before

For all releases from 2.2.1 and below, see the [Github Releases](https://github.com/glhd/laravel-addressing/releases).

[Unreleased]: https://github.com/glhd/laravel-addressing/compare/2.2.1...HEAD

## Keep a Changelog Format

- `Added` for new features
- `Changed` for changes in existing functionality
- `Deprecated` for soon-to-be removed features
- `Removed` for now removed features
- `Fixed` for any bug fixes
- `Security` in case of vulnerabilities
