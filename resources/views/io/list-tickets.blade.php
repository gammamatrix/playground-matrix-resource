@php
    if (! isset($withParent)) {
        $withParent = true;
    }
    if (! isset($withProject)) {
        $withProject = true;
    }
@endphp

<div class="card">
    <div class="card-header">
        @if (! empty($modelColumn) && ! empty($modelLabel))
            <a
                class="btn btn-info float-end"
                href="{{ route("playground.matrix.resource.tickets.create", [$modelColumn => $data->id, "_return_url" => $routeShow]) }}"
                alt=" {{ __("Create a new ticket for the :model_label", ["model_label" => $modelLabel]) }}"
            >
                {{ __("Create") }}
            </a>
        @endif

        <h2>{{ __($headerLabel ?? "Tickets") }}</h2>
    </div>

    @if (! empty($tickets))
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ticket</th>
                            <th>Title</th>
                            <th>Type</th>
                            @if ($withParent)
                                <th>Parent</th>
                            @endif

                            @if ($withProject)
                                <th>Project</th>
                            @endif

                            <th>Epic</th>
                            <th>Label</th>
                            <th>State</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Owner</th>
                            <th>Reporter</th>
                            <th>Team</th>
                            <th>Sprint</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $ticket)
                            <tr>
                                <td>
                                    @if ($ticket->key)
                                        {{ $ticket->key }}
                                    @else
                                        <a
                                            class="btn btn-info"
                                            href="{{ route("playground.matrix.resource.tickets.edit", ["ticket" => $ticket->id]) }}"
                                        >
                                            Edit
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    {{ $ticket->title }}
                                </td>
                                <td>
                                    @if ($ticket->ticket_type)
                                        <a
                                            href="{{ route("playground.matrix.resource.tickets", ["filter" => ["ticket_type" => $ticket->ticket_type]]) }}"
                                        >
                                            {{ $ticket->ticket_type }}
                                        </a>
                                    @endif
                                </td>
                                @if ($withParent)
                                    <td>
                                        @if ($ticket->parent_id)
                                            <a
                                                href="{{ route("playground.matrix.resource.tickets.show", ["ticket" => $ticket->parent_id]) }}"
                                            >
                                                {{ $ticket->parent()->first()->label_or_title }}
                                            </a>
                                        @endif
                                    </td>
                                @endif

                                @if ($withProject)
                                    <td>
                                        @if ($ticket->project_id)
                                            <a
                                                href="{{ route("playground.matrix.resource.projects.show", ["project" => $ticket->project_id]) }}"
                                            >
                                                {{ $ticket->project()->first()->label_or_title }}
                                            </a>
                                        @endif
                                    </td>
                                @endif

                                <td>
                                    @if ($ticket->epic_id)
                                        <a
                                            href="{{ route("playground.matrix.resource.epics.show", ["epic" => $ticket->epic_id]) }}"
                                        >
                                            {{ $ticket->epic()->first()->label_or_title }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    {{ $ticket->label }}
                                </td>
                                <td>
                                    {{ $ticket->state }}
                                </td>
                                <td>
                                    <time
                                        datetime="{{ $ticket->created_at?->toW3cString() }}"
                                    >
                                        {{ $ticket->created_at?->toDayDateTimeString() }}
                                    </time>
                                </td>
                                <td>
                                    <time
                                        datetime="{{ $ticket->updated_at?->toW3cString() }}"
                                    >
                                        {{ $ticket->updated_at?->toDayDateTimeString() }}
                                    </time>
                                </td>
                                <td>
                                    @if ($ticket->owned_by_id)
                                        {{ $ticket->owner()->first()->name }}
                                    @endif
                                </td>
                                <td>
                                    @if ($ticket->reported_by_id)
                                        {{ $ticket->reportedBy()->first()->name }}
                                    @endif
                                </td>
                                <td>
                                    @if ($ticket->team_id)
                                        <a
                                            href="{{ route("playground.matrix.resource.teams.show", ["team" => $ticket->team_id]) }}"
                                        >
                                            {{ $ticket->team()->first()->title }}
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if ($ticket->sprint_id)
                                        <a
                                            href="{{ route("playground.matrix.resource.sprints.show", ["sprint" => $ticket->sprint_id]) }}"
                                        >
                                            {{ $ticket->sprint()->first()->title }}
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
