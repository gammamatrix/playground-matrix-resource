# playground-matrix-resource

The playground-matrix-resource Laravel package.

This package provides an API and a Blade UI for interacting with the Playground Matrix.

## Installation

You can install the package via composer:

```bash
composer require gammamatrix/playground-matrix-resource
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="GammaMatrix\Playground\Matrix\Resource\ServiceProvider" --tag="playground-config"
```

See the contents of the published config file: [config/playground-matrix-resource.php](config/playground-matrix-resource.php)

You can publish the routes file with:
```bash
php artisan vendor:publish --provider="GammaMatrix\Playground\Matrix\Resource\ServiceProvider" --tag="playground-routes"
```

See the authentication routes: [routes](routes)

### Environment Variables

#### Authentication and Authorization

| env()                                         | config()                                      |
|-----------------------------------------------|-----------------------------------------------|
| `PLAYGROUND_MATRIX_RESOURCE_MIDDLEWARE`       | `playground-matrix-resource.middleware`       |
| `PLAYGROUND_MATRIX_RESOURCE_POLICY_NAMESPACE` | `playground-matrix-resource.policy_namespace` |

If you do not want to use the flexible policies available in Playground, you may publish the routes to your base application and customize them and the middleware.

The default middleware is set in [config/playground-matrix-resource.php](config/playground-matrix-resource.php) (may also be published): `'auth:sanctum,web'`

If you wish to use your own policies, copy from [src/Policies](src/Policies).

#### Loading

| env()                                    | config()                                 |
|------------------------------------------|------------------------------------------|
| `PLAYGROUND_MATRIX_RESOURCE_LOAD_ROUTES` | `playground-matrix-resource.load.routes` |
| `PLAYGROUND_MATRIX_RESOURCE_LOAD_VIEWS`  | `playground-matrix-resource.load.views`  |


##### Routes

| env()                                          | config()                              |
|------------------------------------------------|---------------------------------------|
| `PLAYGROUND_MATRIX_RESOURCE_ROUTES_MATRIX`     | `playground-matrix.routes.matrix`     |
| `PLAYGROUND_MATRIX_RESOURCE_ROUTES_BOARDS`     | `playground-matrix.routes.backlogs`   |
| `PLAYGROUND_MATRIX_RESOURCE_ROUTES_EPICS`      | `playground-matrix.routes.boards`     |
| `PLAYGROUND_MATRIX_RESOURCE_ROUTES_FLOWS`      | `playground-matrix.routes.epics`      |
| `PLAYGROUND_MATRIX_RESOURCE_ROUTES_MILESTONES` | `playground-matrix.routes.milestones` |
| `PLAYGROUND_MATRIX_RESOURCE_ROUTES_NOTES`      | `playground-matrix.routes.notes`      |
| `PLAYGROUND_MATRIX_RESOURCE_ROUTES_PROJECTS`   | `playground-matrix.routes.projects`   |
| `PLAYGROUND_MATRIX_RESOURCE_ROUTES_RELEASES`   | `playground-matrix.routes.releases`   |
| `PLAYGROUND_MATRIX_RESOURCE_ROUTES_ROADMAPS`   | `playground-matrix.routes.roadmaps`   |
| `PLAYGROUND_MATRIX_RESOURCE_ROUTES_SOURCES`    | `playground-matrix.routes.sources`    |
| `PLAYGROUND_MATRIX_RESOURCE_ROUTES_SPRINTS`    | `playground-matrix.routes.sprints`    |
| `PLAYGROUND_MATRIX_RESOURCE_ROUTES_TAGS`       | `playground-matrix.routes.tags`       |
| `PLAYGROUND_MATRIX_RESOURCE_ROUTES_TEAMS`      | `playground-matrix.routes.teams`      |
| `PLAYGROUND_MATRIX_RESOURCE_ROUTES_TICKETS`    | `playground-matrix.routes.tickets`    |
| `PLAYGROUND_MATRIX_RESOURCE_ROUTES_VERSIONS`   | `playground-matrix.routes.versions`   |

### UI

| env()                                       | config()                                    |
|---------------------------------------------|---------------------------------------------|
| `PLAYGROUND_MATRIX_RESOURCE_LAYOUT`         | `playground-matrix-resource.layout`         |
| `PLAYGROUND_MATRIX_RESOURCE_VIEW`           | `playground-matrix-resource.view`           |
| `PLAYGROUND_MATRIX_RESOURCE_SITEMAP_ENABLE` | `playground-matrix-resource.sitemap.enable` |
| `PLAYGROUND_MATRIX_RESOURCE_SITEMAP_GUEST`  | `playground-matrix-resource.sitemap.guest`  |
| `PLAYGROUND_MATRIX_RESOURCE_SITEMAP_USER`   | `playground-matrix-resource.sitemap.user`   |
| `PLAYGROUND_MATRIX_RESOURCE_SITEMAP_VIEW`   | `playground-matrix-resource.sitemap.view`   |

## Configuration

All routes are enabled by default. They may be disabled via enviroment variable or the configuration.

See the contents of the published config file: [config/playground-matrix-resource.php](.config/playground-matrix-resource.php)

## Migrations

This package requires the migrations in [playground-matrix](https://github.com/gammamatrix/playground-matrix) a Laravel package.

## Tests

```sh
composer test
```


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.
