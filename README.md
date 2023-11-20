#

The  package.

## Installation

You can install the package via composer:

```bash
composer require gammamatrix/playground-matrix-resource
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="GammaMatrix\Playground\Matrix\Resource\ServiceProvider" --tag="playground-config"
```

See the contents of the published config file: [config/playground-auth.php](config/playground-auth.php)

You can publish the routes file with:
```bash
php artisan vendor:publish --provider="GammaMatrix\Playground\Matrix\Resource\ServiceProvider" --tag="playground-routes"
```

See the authentication routes: [routes](routes)

## Configuration

All options are disabled by default.

See the contents of the published config file: [config/playground-matrix-resource.php](.config/playground-matrix-resource.php)


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.
