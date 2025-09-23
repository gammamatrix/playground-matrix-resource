<?php
if(empty($dashboard) || !($dashboard instanceof Playground\Matrix\Resource\Dashboard\Index)) {
    return;
}
?>
<div class="col">
    <div class="card m-1">
        <div class="card-header">
            <h3>
                Teams
                <span class="badge rounded-pill text-bg-primary">
                    <?= $dashboard->getCount("Team") ?>
                </span>
            </h3>
        </div>
        <div class="card-body">
            <p class="card-text"></p>
            <a
                class="card-link"
                href="{{ route("playground.matrix.resource.teams") }}"
            >
                View Teams
            </a>
        </div>
        @if ($dashboard->hasLinks("Team"))
            <ul class="list-group list-group-flush">
                @foreach ($dashboard->getLinks("Team") as $link)
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
