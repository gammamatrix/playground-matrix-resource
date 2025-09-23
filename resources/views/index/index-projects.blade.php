<?php
if(empty($dashboard) || !($dashboard instanceof Playground\Matrix\Resource\Dashboard\Index)) {
    return;
}
$user = \Illuminate\Support\Facades\Auth::user();
?>
<?php
$withCreateMatrix = \Playground\Auth\Facades\Can::access($user, [
    "allow" => false,
    "any" => true,
    "privilege" => "playground-matrix-resource:matrix:create",
    "roles" => ["admin", "manager"],
])->allowed();
?>

<div class="col-sm-6">
    <div class="card m-1">
        <div class="card-header">
            <h2>
                Projects
                <span class="badge rounded-pill text-bg-primary">
                    <?= $dashboard->getCount("Project") ?>
                </span>
            </h2>
        </div>
        <div class="card-body">
            @if ($withCreateMatrix)
                <a
                    class="btn btn-success"
                    href="{{ route("playground.matrix.resource.projects.create") }}"
                    role="button"
                >
                    Create
                </a>
            @endif

            <a
                class="btn btn-info"
                href="{{ route("playground.matrix.resource.projects") }}"
                role="button"
            >
                View
            </a>
            <a
                class="btn btn-warning"
                href="{{
                    route("playground.matrix.resource.projects", [
                        "filter" => ["trash" => "only"],
                    ])
                }}"
                role="button"
                title="View projects in the trash"
            >
                <i class="fa-solid fa-trash"></i>
            </a>
        </div>
        @if ($dashboard->hasLinks("Project"))
            <ul class="list-group list-group-flush">
                @foreach ($dashboard->getLinks("Project") as $link)
                    <li class="list-group-item">
                        <a
                            href="{{ $link->uri }}"
                            alt="{{ $link->description ?? "" }}"
                        >
                            {{ $link->label }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
