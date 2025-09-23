<?php
if(empty($dashboard) || !($dashboard instanceof Playground\Matrix\Resource\Dashboard\Index)) {
    return;
}
?>
<div class="col-sm-6">
    <div class="card m-1">
        <div class="card-header">
            <h3>
                Roadmaps
                <span class="badge rounded-pill text-bg-primary">
                    <?= $dashboard->getCount("Roadmap") ?>
                </span>
            </h3>
        </div>
        <div class="card-body">
            <p class="card-text"></p>
            <a
                class="card-link"
                href="{{ route("playground.matrix.resource.roadmaps") }}"
            >
                View Roadmaps
            </a>
        </div>
        @if ($dashboard->hasLinks("Roadmap"))
            <ul class="list-group list-group-flush">
                @foreach ($dashboard->getLinks("Roadmap") as $link)
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
