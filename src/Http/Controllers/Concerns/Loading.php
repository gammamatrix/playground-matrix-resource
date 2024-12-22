<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Matrix\Resource\Http\Controllers\Concerns;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Playground\Matrix\Models;
use Playground\Matrix\Resource\Dashboard\Index as IndexDashboard;

/**
 * \Playground\Matrix\Resource\Http\Controllers\Concerns\Loading
 */
trait Loading
{
    public function loadMatrix(
        Request $request,
        string $route,
    ): IndexDashboard
    {
        $dashboard = new IndexDashboard;
        $data = [];

        $user = auth()->user();

        $load = [
            'Backlog' => [
                'route' => 'backlogs',
            ],
            'Board' => [
                'route' => 'boards',
            ],
            'Epic' => [
                'route' => 'epics',
            ],
            'Flow' => [
                'route' => 'flows',
            ],
            'Matrix' => [
                'route' => 'matrices',
            ],
            'Milestone' => [
                'route' => 'milestones',
            ],
            'Note' => [
                'route' => 'notes',
            ],
            'Project' => [
                'route' => 'projects',
            ],
            'Release' => [
                'route' => 'releases',
            ],
            'Roadmap' => [
                'route' => 'roadmaps',
            ],
            'Source' => [
                'route' => 'sources',
            ],
            'Sprint' => [
                'route' => 'sprints',
            ],
            'Tag' => [
                'route' => 'tags',
            ],
            'Team' => [
                'route' => 'teams',
            ],
            'Ticket' => [
                'route' => 'tickets',
                // 'orderBy' => [
                //     'updated_at' => 'desc',
                // ],
            ],
            'Version' => [
                'route' => 'versions',
            ],
        ];

        foreach ($load as $key => $meta) {
            $class = '\\Playground\\Matrix\Models\\'.$key;
            $data[$key] = $class::all();

            $dashboard->setLabel($key, $key);
            $dashboard->setCount($key, $data[$key]->count());

            foreach($data[$key] as $model) {
                $dashboard->addLink($key, [
                    'description' => $model->description,
                    'label' => $model->label ?: $model->title,
                    'uri' => route(sprintf(
                        '%1$s.%2$s.show',
                        $route,
                        $meta['route']
                    ), $model->id),
                    'target' => 'internal',
                ]);
            }
        }

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     // '$user' => $user,
        //     '$dashboard' => $dashboard,
        //     // '$data[matrices]' => $data['matrices'],
        //     // 'get_class_methods($data[matrices])' => get_class_methods($data['matrices']),
        // ]);

        return $dashboard;
    }
}
