<?php
/**
 * Playground
 */
namespace Playground\Matrix\Resource;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Playground\Matrix\Models;

/**
 * \Playground\Matrix\Resource\ServiceProvider
 */
class ServiceProvider extends AuthServiceProvider
{
    use ServiceProviderTrait;

    public const VERSION = '73.0.0';

    protected string $package = 'playground-matrix-resource';

    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Models\Backlog::class => Policies\BacklogPolicy::class,
        Models\Board::class => Policies\BoardPolicy::class,
        Models\Epic::class => Policies\EpicPolicy::class,
        Models\Flow::class => Policies\FlowPolicy::class,
        Models\Milestone::class => Policies\MilestonePolicy::class,
        Models\Note::class => Policies\NotePolicy::class,
        Models\Project::class => Policies\ProjectPolicy::class,
        Models\Release::class => Policies\ReleasePolicy::class,
        Models\Roadmap::class => Policies\RoadmapPolicy::class,
        Models\Source::class => Policies\SourcePolicy::class,
        Models\Sprint::class => Policies\SprintPolicy::class,
        Models\Tag::class => Policies\TagPolicy::class,
        Models\Team::class => Policies\TeamPolicy::class,
        Models\Ticket::class => Policies\TicketPolicy::class,
        Models\Version::class => Policies\VersionPolicy::class,
    ];

    /**
     * Bootstrap any package services.
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        /**
         * @var array<string, mixed> $config
         */
        $config = config($this->package);

        if (! empty($config['load']) && is_array($config['load'])) {

            // $this->loadTranslationsFrom(
            //     dirname(__DIR__).'/resources/lang',
            //     'playground-matrix-resource'
            // );

            if (! empty($config['load']['policies'])) {
                $this->setPolicyNamespace($config);
                $this->registerPolicies();
            }

            if (! empty($config['load']['routes'])
                && ! empty($config['routes'])
                && is_array($config['routes'])
            ) {
                $this->routes($config['routes']);
            }

            if (! empty($config['load']['views'])) {
                $this->loadViewsFrom(
                    dirname(__DIR__).'/resources/views',
                    $this->package
                );
            }

            if ($this->app->runningInConsole()) {
                // Publish configuration
                $this->publishes([
                    sprintf('%1$s/config/%2$s.php', dirname(__DIR__), $this->package) => config_path(sprintf('%1$s.php', $this->package)),
                ], 'playground-config');

                // Publish routes
                $this->publishes([
                    dirname(__DIR__).'/routes' => base_path('routes/playground-matrix-resource'),
                ], 'playground-routes');
            }
        }

        $this->about();
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/config/playground-matrix-resource.php',
            $this->package
        );
    }

    /**
     * @param array<string, mixed> $config
     */
    public function routes(array $config): void
    {
        if (! empty($config['matrix'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/matrix.php');
        }
        if (! empty($config['backlogs'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/backlogs.php');
        }
        if (! empty($config['boards'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/boards.php');
        }
        if (! empty($config['epics'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/epics.php');
        }
        if (! empty($config['flows'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/flows.php');
        }
        if (! empty($config['milestones'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/milestones.php');
        }
        if (! empty($config['notes'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/notes.php');
        }
        if (! empty($config['projects'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/projects.php');
        }
        if (! empty($config['releases'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/releases.php');
        }
        if (! empty($config['roadmaps'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/roadmaps.php');
        }
        if (! empty($config['sources'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/sources.php');
        }
        if (! empty($config['sprints'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/sprints.php');
        }
        if (! empty($config['tags'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/tags.php');
        }
        if (! empty($config['teams'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/teams.php');
        }
        if (! empty($config['tickets'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/tickets.php');
        }
        if (! empty($config['versions'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/versions.php');
        }
    }

    public function about(): void
    {
        $config = config($this->package);
        $config = is_array($config) ? $config : [];

        $load = ! empty($config['load']) && is_array($config['load']) ? $config['load'] : [];

        $middleware = ! empty($config['middleware']) && is_array($config['middleware']) ? $config['middleware'] : [];

        $routes = ! empty($config['routes']) && is_array($config['routes']) ? $config['routes'] : [];

        $sitemap = ! empty($config['sitemap']) && is_array($config['sitemap']) ? $config['sitemap'] : [];

        $version = $this->version();

        AboutCommand::add('Playground Matrix Resource', fn () => [
            '<fg=yellow;options=bold>Load</> Policies' => ! empty($load['policies']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=yellow;options=bold>Load</> Routes' => ! empty($load['routes']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=yellow;options=bold>Load</> Views' => ! empty($load['views']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=cyan;options=bold>Policy</> [namespace]' => sprintf('[%s]', $config['policy_namespace']),

            '<fg=yellow;options=bold>Middleware</> auth' => sprintf('%s', json_encode($middleware['auth'])),
            '<fg=yellow;options=bold>Middleware</> default' => sprintf('%s', json_encode($middleware['default'])),
            '<fg=yellow;options=bold>Middleware</> guest' => sprintf('%s', json_encode($middleware['guest'])),

            '<fg=blue;options=bold>View</> [layout]' => sprintf('[%s]', $config['layout']),
            '<fg=blue;options=bold>View</> [prefix]' => sprintf('[%s]', $config['view']),

            '<fg=magenta;options=bold>Sitemap</> Views' => ! empty($sitemap['enable']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=magenta;options=bold>Sitemap</> Guest' => ! empty($sitemap['guest']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=magenta;options=bold>Sitemap</> User' => ! empty($sitemap['user']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=magenta;options=bold>Sitemap</> [view]' => sprintf('[%s]', $sitemap['view']),

            '<fg=red;options=bold>Route</> matrix' => ! empty($routes['matrix']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> backlogs' => ! empty($routes['backlogs']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> boards' => ! empty($routes['boards']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> epics' => ! empty($routes['epics']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> flows' => ! empty($routes['flows']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> milestones' => ! empty($routes['milestones']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> notes' => ! empty($routes['notes']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> projects' => ! empty($routes['projects']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> releases' => ! empty($routes['releases']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> roadmaps' => ! empty($routes['roadmaps']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> sources' => ! empty($routes['sources']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> sprints' => ! empty($routes['sprints']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> tags' => ! empty($routes['tags']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> teams' => ! empty($routes['teams']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> tickets' => ! empty($routes['tickets']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> versions' => ! empty($routes['versions']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',

            'Package' => $this->package,
            'Version' => $version,
        ]);
    }

    public function version(): string
    {
        return static::VERSION;
    }
}
