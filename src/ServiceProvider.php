<?php
/**
 * GammaMatrix
 */

namespace GammaMatrix\Playground\Matrix\Resource;

use GammaMatrix\Playground\Matrix\Models;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

/**
 * \GammaMatrix\Playground\Matrix\Resource\ServiceProvider
 */
class ServiceProvider extends AuthServiceProvider
{
    use ServiceProviderTrait;

    public const VERSION = '73.0.0';

    protected string $package = 'playground-matrix-resource';

    /**
     * The policy mappings for the application.
     *
     * @var array
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
     *
     * @return void
     */
    public function boot()
    {
        $config = config($this->package);

        if (!empty($config)) {

            if (!empty($config['load']['policies'])) {
                $this->setPolicyNamespace($config);
                $this->registerPolicies();
            }

            if (!empty($config['load']['routes'])) {
                $this->routes($config);
            }

            if (!empty($config['load']['views'])) {
                $this->loadViewsFrom(
                    dirname(__DIR__) . '/resources/views',
                    $this->package
                );
            }

            if ($this->app->runningInConsole()) {
                // Publish configuration
                $this->publishes([
                    dirname(__DIR__).'/config/'.$this->package.'.php'
                        => config_path($this->package.'.php')
                ], 'playground-config');
            }
        }

        $this->about();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/config/'.$this->package.'.php',
            $this->package
        );
    }

    public function routes(array $config)
    {
        if (!empty($config['routes']['matrix'])) {
            $this->loadRoutesFrom(dirname(__DIR__) . '/routes/matrix.php');
        }
        if (!empty($config['routes']['backlogs'])) {
            $this->loadRoutesFrom(dirname(__DIR__) . '/routes/backlogs.php');
        }
        if (!empty($config['routes']['boards'])) {
            $this->loadRoutesFrom(dirname(__DIR__) . '/routes/boards.php');
        }
        if (!empty($config['routes']['epics'])) {
            $this->loadRoutesFrom(dirname(__DIR__) . '/routes/epics.php');
        }
        if (!empty($config['routes']['flows'])) {
            $this->loadRoutesFrom(dirname(__DIR__) . '/routes/flows.php');
        }
        if (!empty($config['routes']['milestones'])) {
            $this->loadRoutesFrom(dirname(__DIR__) . '/routes/milestones.php');
        }
        if (!empty($config['routes']['notes'])) {
            $this->loadRoutesFrom(dirname(__DIR__) . '/routes/notes.php');
        }
        if (!empty($config['routes']['projects'])) {
            $this->loadRoutesFrom(dirname(__DIR__) . '/routes/projects.php');
        }
        if (!empty($config['routes']['releases'])) {
            $this->loadRoutesFrom(dirname(__DIR__) . '/routes/releases.php');
        }
        if (!empty($config['routes']['roadmaps'])) {
            $this->loadRoutesFrom(dirname(__DIR__) . '/routes/roadmaps.php');
        }
        if (!empty($config['routes']['sources'])) {
            $this->loadRoutesFrom(dirname(__DIR__) . '/routes/sources.php');
        }
        if (!empty($config['routes']['sprints'])) {
            $this->loadRoutesFrom(dirname(__DIR__) . '/routes/sprints.php');
        }
        if (!empty($config['routes']['tags'])) {
            $this->loadRoutesFrom(dirname(__DIR__) . '/routes/tags.php');
        }
        if (!empty($config['routes']['teams'])) {
            $this->loadRoutesFrom(dirname(__DIR__) . '/routes/teams.php');
        }
        if (!empty($config['routes']['tickets'])) {
            $this->loadRoutesFrom(dirname(__DIR__) . '/routes/tickets.php');
        }
        if (!empty($config['routes']['versions'])) {
            $this->loadRoutesFrom(dirname(__DIR__) . '/routes/versions.php');
        }
    }

    public function about()
    {
        $config = config($this->package);

        $version = $this->version();

        $redirect = defined('\App\Providers\RouteServiceProvider::HOME') ? \App\Providers\RouteServiceProvider::HOME : null;

        AboutCommand::add('Playground Matrix Resource', fn () => [
            '<fg=yellow;options=bold>Load</> Routes' => !empty($config['load']['routes']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=yellow;options=bold>Load</> Views' => !empty($config['load']['views']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',

            '<fg=blue;options=bold>View</> Layout' => $config['layout'],
            '<fg=blue;options=bold>View</> [prefix]' => sprintf('[%s]', $config['view']),

            '<fg=magenta;options=bold>Sitemap</> Views' => !empty($config['sitemap']['enable']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=magenta;options=bold>Sitemap</> Guest' => !empty($config['sitemap']['guest']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=magenta;options=bold>Sitemap</> User' => !empty($config['sitemap']['user']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=magenta;options=bold>Sitemap</> [view]' => sprintf('[%s]', $config['sitemap']['view']),

            'Package' => $this->package,
            'Version' => $version,
        ]);
    }

    public function version()
    {
        return static::VERSION;
    }
}
