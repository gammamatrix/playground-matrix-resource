<?php
if (
    empty($dashboard) ||
    ! ($dashboard instanceof Playground\Matrix\Resource\Dashboard\Index)
) {
    return;
}
?>

<div class="col-sm-6">
    <div class="card m-1">
        <div class="card-header">
            <h2>
                Sprints
                <span class="badge rounded-pill text-bg-primary">
                    <?= $dashboard->getCount("Sprint") ?>
                </span>
            </h2>
        </div>
        <div class="card-body">
            <p class="card-text"></p>
            <a
                class="card-link"
                href="{{ route("playground.matrix.resource.sprints") }}"
            >
                View Sprints
            </a>
        </div>
        @if ($dashboard->hasLinks("Sprint"))
            <ul class="list-group list-group-flush">
                @foreach ($dashboard->getLinks("Sprint") as $link)
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
