# Playground Matrix Resource

[![Playground CI Workflow](https://github.com/gammamatrix/playground-matrix-resource/actions/workflows/ci.yml/badge.svg?branch=develop)](https://raw.githubusercontent.com/gammamatrix/playground-matrix-resource/testing/develop/testdox.txt)
[![Test Coverage](https://raw.githubusercontent.com/gammamatrix/playground-matrix-resource/testing/develop/coverage.svg)](tests)
[![PHPStan Level 9 src and tests](https://img.shields.io/badge/PHPStan-level%209-brightgreen)](.github/workflows/ci.yml#L120)

The `playground-matrix-resource` Laravel package.

This package provides an API and a Blade UI for interacting with the [Playground Matrix](https://github.com/gammamatrix/playground-matrix), a project management and task system.

If you only need the JSON API, the Blade UI may be disabled.

This application provides Swagger documentation: [swagger.json](swagger.json).
- See the [Playground Matrix Resource swagger.json on the Swagger Editor.](https://editor.swagger.io/?url=https://raw.githubusercontent.com/gammamatrix/playground-matrix-resource/develop/swagger.json)
- The endpoint models support locks, trash with force delete, restoring and more.
- Index endpoints support advanced query filtering.

Read more on using Playground Matrix Resource [at the Read the Docs for Playground.](https://gammamatrix-playground.readthedocs.io/)

## Installation

You can install the package via composer:

```bash
composer require gammamatrix/playground-matrix-resource
```

## About

Playground provides information in the `artisan about` command.

<img src="resources/docs/artisan-about-playground-matrix-resource.png" alt="screenshot of artisan about command with Playground Matrix Resource.">

## Configuration

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Playground\Matrix\Resource\ServiceProvider" --tag="playground-config"
```

All routes are enabled by default. They may be disabled via enviroment variable or the configuration.

See the contents of the published config file: [config/playground-matrix-resource.php](config/playground-matrix-resource.php)

You can publish the routes file with:
```bash
php artisan vendor:publish --provider="Playground\Matrix\Resource\ServiceProvider" --tag="playground-routes"
```
- The routes while be published in a folder at `routes/playground-matrix-resource`

### Environment Variables

If you are unable or do not want to publish [configuration files for this package](config/playground-matrix-resource.php),
you may override the options via system environment variables.

Information on [environment variables is available on the wiki for this package](https://github.com/gammamatrix/playground-matrix-resource/wiki/Environment-Variables)


## Migrations

This package requires the migrations in [playground-matrix](https://github.com/gammamatrix/playground-matrix) a Laravel package.

## PHPStan

Tests at level 9 on:
- `config/`
- `database/`
- `resources/views/`
- `routes/`
- `src/`
- `tests/Feature/`
- `tests/Unit/`

```sh
composer analyse
```

## Coding Standards

```sh
composer format
```

## Tests

```sh
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.
