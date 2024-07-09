<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Matrix\Resource\Http\Controllers\Playground;

use Playground\Matrix\Models\Project;
use Playground\Matrix\Models\Ticket;
use Playground\Models\User;
use Tests\Feature\Playground\Matrix\Resource\Http\Controllers\TicketTestCase;

/**
 * \Tests\Feature\Playground\Matrix\Resource\Http\Controllers\Playground\TicketRouteTest
 */
class TicketRouteTest extends TicketTestCase
{
    protected bool $load_migrations_playground = true;

    protected bool $setUpUserForPlayground = true;

    public function test_admin_can_create_ticket_with_project(): void
    {
        /**
         * @var Project $project
         */
        $project = Project::factory()->create([
            'key' => 'testing',
        ]);

        /**
         * @var Ticket $ticket
         */
        $ticket = Ticket::factory()->make([
            'project_id' => $project->id,
            'priority' => '<strong>fire</strong>',
            'resolution' => '<i>unresolved</i>',
            'severity' => '<em>medium</em>',
            'step' => '<a href="step"></a>',
            'handler' => '<b>handler</b>',
            'state' => 'state',
            'workflow_type' => 'workflow_type',
            'actual' => '<b>actual</b>',
            'expected' => '<a>expected</a>',
            'steps' => '<b>steps</b>',
            'story' => '<i>story</b>',
            'criteria' => 'Important <em>criteria</em>',
        ]);

        /**
         * @var User $user
         */
        $user = User::factory()->admin()->create();

        $url = route('playground.matrix.resource.tickets.post');

        $data = $ticket->toArray();

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     'project' => $project->toArray(),
        //     'ticket' => $ticket->toArray(),
        //     // 'user' => $user->toArray(),
        //     '$url' => $url,
        // ]);

        $response = $this->actingAs($user)->postJson($url, $data);

        // $response->dump();
        $response->assertStatus(201);

        $response->assertJsonPath('data.project_id', $ticket->project_id);
        $response->assertJsonPath('data.project_id', $project->id);
        $response->assertJsonPath('data.handler', 'handler');
        $response->assertJsonPath('data.priority', 'fire');
        $response->assertJsonPath('data.resolution', 'unresolved');
        $response->assertJsonPath('data.severity', 'medium');
        $response->assertJsonPath('data.step', '');
        $response->assertJsonPath('data.state', 'state');
        $response->assertJsonPath('data.workflow_type', 'workflow_type');
        $response->assertJsonPath('data.actual', '<b>actual</b>');
        $response->assertJsonPath('data.expected', '<a>expected</a>');
        $response->assertJsonPath('data.steps', '<b>steps</b>');
        $response->assertJsonPath('data.story', '<i>story</i>');
        $response->assertJsonPath('data.criteria', 'Important <em>criteria</em>');

        $this->assertAuthenticated();
    }

    public function test_admin_can_update_ticket_with_project(): void
    {
        /**
         * @var Project $project
         */
        $project = Project::factory()->create([
            'key' => 'testing',
        ]);

        /**
         * @var Ticket $ticket
         */
        $ticket = Ticket::factory()->create([
            'project_id' => $project->id,
        ]);

        /**
         * @var Ticket $ticket
         */
        $ticket_update = Ticket::factory()->make([
            'project_id' => $project->id,
            'priority' => '<strong>fire</strong>',
            'resolution' => '<i>unresolved</i>',
            'severity' => '<em>medium</em>',
            'step' => '<a href="step"></a>',
            'handler' => '<b>handler</b>',
            'state' => 'state',
            'workflow_type' => 'workflow_type',
            'actual' => '<b>actual</b>',
            'expected' => '<a>expected</a>',
            'steps' => '<b>steps</b>',
            'story' => '<i>story</b>',
            'criteria' => 'Important <em>criteria</em>',
        ]);

        /**
         * @var User $user
         */
        $user = User::factory()->admin()->create();

        $url = route('playground.matrix.resource.tickets.patch', $ticket);

        $data = $ticket_update->toArray();

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     'project' => $project->toArray(),
        //     'ticket' => $ticket->toArray(),
        //     // 'user' => $user->toArray(),
        //     '$url' => $url,
        // ]);

        $response = $this->actingAs($user)->patchJson($url, $data);

        // $response->dump();
        $response->assertStatus(200);

        $response->assertJsonPath('data.project_id', $ticket->project_id);
        $response->assertJsonPath('data.project_id', $project->id);
        $response->assertJsonPath('data.project_id', $ticket_update->project_id);
        $response->assertJsonPath('data.handler', 'handler');
        $response->assertJsonPath('data.priority', 'fire');
        $response->assertJsonPath('data.resolution', 'unresolved');
        $response->assertJsonPath('data.severity', 'medium');
        $response->assertJsonPath('data.step', '');
        $response->assertJsonPath('data.state', 'state');
        $response->assertJsonPath('data.workflow_type', 'workflow_type');
        $response->assertJsonPath('data.actual', '<b>actual</b>');
        $response->assertJsonPath('data.expected', '<a>expected</a>');
        $response->assertJsonPath('data.steps', '<b>steps</b>');
        $response->assertJsonPath('data.story', '<i>story</i>');
        $response->assertJsonPath('data.criteria', 'Important <em>criteria</em>');

        $this->assertAuthenticated();
    }
}
