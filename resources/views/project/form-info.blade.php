<fieldset class="mb-3">

    <legend>Information</legend>

    <x-playground::forms.column column="title" label="Title" :autocomplete="false" :rules="[
        'required' => true,
        'maxlength' => 255,
    ]">
        You should provide a <strong>title.</strong>
    </x-playground::forms.column>

    <x-playground::forms.column column="label" label="Label" :autocomplete="false" :rules="[
        'required' => false,
        'maxlength' => 255,
    ]">
    </x-playground::forms.column>

    <x-playground::forms.column column="slug" label="SLUG" :autocomplete="false" :rules="[
        'required' => !empty($_method) && 'patch' === $_method,
        'maxlength' => 255,
    ]" />

    <x-playground::forms.column column="code_name" label="Code Name" :autocomplete="false" :rules="[
        'required' => !empty($_method) && 'patch' === $_method,
        'maxlength' => 255,
    ]" />

    <x-playground::forms.column column="key" label="Key" :autocomplete="false" :rules="[
        'required' => !empty($_method) && 'patch' === $_method,
        'maxlength' => 255,
    ]" />

    <x-playground::forms.column column="project_type" label="Project Type" :rules="['maxlength' => 255]" />

    @php
    if ('patch' === $_method) {
        $parents = Playground\Matrix\Models\Ticket::where('id', '!=', $data->id)->get();
    } else {
        $parents = Playground\Matrix\Models\Ticket::isNotClosed()->isActive()->get();
    }
    @endphp
    @if ($parents->isEmpty())
    <input type="hidden" name="parent_id" value="" />
    @else
    <x-playground::forms.column-select column="parent_id" key="label" label="Parent Project" :records="$parents->toArray()"/>
    @endif

    @php $boards = Playground\Matrix\Models\Board::all() @endphp
    @if ($boards->isEmpty())
    <input type="hidden" name="board_id" value="" />
    @else
    <x-playground::forms.column-select column="board_id" key="title" label="Board" :records="$boards->toArray()"/>
    @endif

    @php $epics = Playground\Matrix\Models\Epic::all() @endphp
    @if ($epics->isEmpty())
    <input type="hidden" name="epic_id" value="" />
    @else
    <x-playground::forms.column-select column="epic_id" key="title" label="Epic" :records="$epics->toArray()"/>
    @endif

    @php $flows = Playground\Matrix\Models\Flow::all() @endphp
    @if ($flows->isEmpty())
    <input type="hidden" name="flow_id" value="" />
    @else
    <x-playground::forms.column-select column="flow_id" key="title" label="Flow" :records="$flows->toArray()"/>
    @endif

    @php $backlogs = Playground\Matrix\Models\Backlog::all() @endphp
    @if ($backlogs->isEmpty())
    <input type="hidden" name="backlog_id" value="" />
    @else
    <x-playground::forms.column-select column="backlog_id" key="title" label="Backlog" :records="$backlogs->toArray()"/>
    @endif

    @php $flows = Playground\Matrix\Models\Flow::all() @endphp
    @if ($flows->isEmpty())
    <input type="hidden" name="flow_id" value="" />
    @else
    <x-playground::forms.column-select column="flow_id" key="title" label="Flow" :records="$flows->toArray()"/>
    @endif

    @php $matrices = Playground\Matrix\Models\Matrix::all() @endphp
    @if ($matrices->isEmpty())
    <input type="hidden" name="matrix_id" value="" />
    @else
    <x-playground::forms.column-select column="matrix_id" key="title" label="Matrix" :records="$matrices->toArray()"/>
    @endif

    @php $milestones = Playground\Matrix\Models\Milestone::all() @endphp
    @if ($milestones->isEmpty())
    <input type="hidden" name="milestone_id" value="" />
    @else
    <x-playground::forms.column-select column="milestone_id" key="title" label="Milestone" :records="$milestones->toArray()"/>
    @endif

    @php $notes = Playground\Matrix\Models\Note::all() @endphp
    @if ($notes->isEmpty())
    <input type="hidden" name="note_id" value="" />
    @else
    <x-playground::forms.column-select column="note_id" key="title" label="Note" :records="$notes->toArray()"/>
    @endif

    @php $releases = Playground\Matrix\Models\Release::all() @endphp
    @if ($releases->isEmpty())
    <input type="hidden" name="release_id" value="" />
    @else
    <x-playground::forms.column-select column="release_id" key="title" label="Release" :records="$releases->toArray()"/>
    @endif

    @php $roadmaps = Playground\Matrix\Models\Roadmap::all() @endphp
    @if ($roadmaps->isEmpty())
    <input type="hidden" name="roadmap_id" value="" />
    @else
    <x-playground::forms.column-select column="roadmap_id" key="title" label="Roadmap" :records="$roadmaps->toArray()"/>
    @endif

    @php $sources = Playground\Matrix\Models\Source::all() @endphp
    @if ($sources->isEmpty())
    <input type="hidden" name="source_id" value="" />
    @else
    <x-playground::forms.column-select column="source_id" key="title" label="Source" :records="$sources->toArray()"/>
    @endif

    @php $sprints = Playground\Matrix\Models\Sprint::all() @endphp
    @if ($sprints->isEmpty())
    <input type="hidden" name="sprint_id" value="" />
    @else
    <x-playground::forms.column-select column="sprint_id" key="title" label="Sprint" :records="$sprints->toArray()"/>
    @endif

    @php $tags = Playground\Matrix\Models\Tag::all() @endphp
    @if ($tags->isEmpty())
    <input type="hidden" name="tag_id" value="" />
    @else
    <x-playground::forms.column-select column="tag_id" key="title" label="Tag" :records="$tags->toArray()"/>
    @endif

    @php $teams = Playground\Matrix\Models\Team::all() @endphp
    @if ($teams->isEmpty())
    <input type="hidden" name="team_id" value="" />
    @else
    <x-playground::forms.column-select column="team_id" key="title" label="Team" :records="$teams->toArray()"/>
    @endif

    @php $tickets = Playground\Matrix\Models\Ticket::all() @endphp
    @if ($tickets->isEmpty())
    <input type="hidden" name="ticket_id" value="" />
    @else
    <x-playground::forms.column-select column="ticket_id" key="title" label="Ticket" :records="$tickets->toArray()"/>
    @endif

    @php $versions = Playground\Matrix\Models\Version::all() @endphp
    @if ($versions->isEmpty())
    <input type="hidden" name="version_id" value="" />
    @else
    <x-playground::forms.column-select column="version_id" key="title" label="Version" :records="$versions->toArray()"/>
    @endif
</fieldset>
