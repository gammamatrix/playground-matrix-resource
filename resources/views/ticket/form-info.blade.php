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

    <x-playground::forms.column column="ticket_type" label="Ticket Type" :rules="['maxlength' => 255]" />

    @php
    if ('patch' === $_method) {
        $parents = Playground\Matrix\Models\Ticket::where('id', '!=', $data->id)->get();
    } else {
        $parents = Playground\Matrix\Models\Ticket::isNotClosed()->isActive()->get();
    }
    @endphp
    @if (!empty($parents))
    <x-playground::forms.column-select column="parent_id" key="title" label="Parent Ticket" :records="$parents->toArray()" :flags="[
        'active' => [
            'disabled' => 'inactive',
            'enabled' => '',
        ],
        'closed' => [
            'disabled' => '',
            'enabled' => 'closed',
        ],
    ]"/>
    @endif

    @php $boards = Playground\Matrix\Models\Board::all() @endphp
    @if (!empty($boards))
    <x-playground::forms.column-select column="board_id" key="title" label="Board" :records="$boards->toArray()"/>
    @endif

    @php $epics = Playground\Matrix\Models\Epic::all() @endphp
    @if (!empty($epics))
    <x-playground::forms.column-select column="epic_id" key="title" label="Epic" :records="$epics->toArray()"/>
    @endif

    @php $flows = Playground\Matrix\Models\Flow::all() @endphp
    @if (!empty($flows))
    <x-playground::forms.column-select column="flow_id" key="title" label="Flow" :records="$flows->toArray()"/>
    @endif

    @php $backlogs = Playground\Matrix\Models\Backlog::all() @endphp
    @if (!empty($backlogs))
    <x-playground::forms.column-select column="backlog_id" key="title" label="Backlog" :records="$backlogs->toArray()"/>
    @endif

    @php $flows = Playground\Matrix\Models\Flow::all() @endphp
    @if (!empty($flows))
    <x-playground::forms.column-select column="flow_id" key="title" label="Flow" :records="$flows->toArray()"/>
    @endif

    @php $matrices = Playground\Matrix\Models\Matrix::all() @endphp
    @if (!empty($matrices))
    <x-playground::forms.column-select column="matrix_id" key="title" label="Matrix" :records="$matrices->toArray()"/>
    @endif

    @php $milestones = Playground\Matrix\Models\Milestone::all() @endphp
    @if (!empty($milestones))
    <x-playground::forms.column-select column="milestone_id" key="title" label="Milestone" :records="$milestones->toArray()"/>
    @endif

    @php $notes = Playground\Matrix\Models\Note::all() @endphp
    @if (!empty($notes))
    <x-playground::forms.column-select column="note_id" key="title" label="Note" :records="$notes->toArray()"/>
    @endif

    @php $projects = Playground\Matrix\Models\Project::all() @endphp
    @if (!empty($projects))
    <x-playground::forms.column-select column="project_id" key="title" label="Project" :records="$projects->toArray()"/>
    @endif

    @php $releases = Playground\Matrix\Models\Release::all() @endphp
    @if (!empty($releases))
    <x-playground::forms.column-select column="release_id" key="title" label="Release" :records="$releases->toArray()"/>
    @endif

    @php $roadmaps = Playground\Matrix\Models\Roadmap::all() @endphp
    @if (!empty($roadmaps))
    <x-playground::forms.column-select column="roadmap_id" key="title" label="Roadmap" :records="$roadmaps->toArray()"/>
    @endif

    @php $sources = Playground\Matrix\Models\Source::all() @endphp
    @if (!empty($sources))
    <x-playground::forms.column-select column="source_id" key="title" label="Source" :records="$sources->toArray()"/>
    @endif

    @php $sprints = Playground\Matrix\Models\Sprint::all() @endphp
    @if (!empty($sprints))
    <x-playground::forms.column-select column="sprint_id" key="title" label="Sprint" :records="$sprints->toArray()"/>
    @endif

    @php $tags = Playground\Matrix\Models\Tag::all() @endphp
    @if (!empty($tags))
    <x-playground::forms.column-select column="tag_id" key="title" label="Tag" :records="$tags->toArray()"/>
    @endif

    @php $teams = Playground\Matrix\Models\Team::all() @endphp
    @if (!empty($teams))
    <x-playground::forms.column-select column="team_id" key="title" label="Team" :records="$teams->toArray()"/>
    @endif

    @php $versions = Playground\Matrix\Models\Version::all() @endphp
    @if (!empty($versions))
    <x-playground::forms.column-select column="version_id" key="title" label="Version" :records="$versions->toArray()"/>
    @endif

</fieldset>
