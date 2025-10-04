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
                Matrices
                <span class="badge rounded-pill text-bg-primary">
                    <?= $dashboard->getCount("Matrix") ?>
                </span>
            </h2>
        </div>
        <div class="card-body">
            <p class="card-text"></p>
            <a
                class="card-link"
                href="{{ route("playground.matrix.resource.matrices") }}"
            >
                View Matrices
            </a>
        </div>
        @if ($dashboard->hasLinks("Matrix"))
            <ul class="list-group list-group-flush">
                @foreach ($dashboard->getLinks("Matrix") as $link)
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
