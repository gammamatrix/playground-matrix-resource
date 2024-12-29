<div class="col-sm-6">
    <div class="card m-1">
        <div class="card-header">
            <h2>
                Boards
                <span class="badge rounded-pill text-bg-primary">
                    <?= $dashboard->getCount('Board') ?>
                </span>
            </h2>
        </div>
        <div class="card-body">
            <p class="card-text"></p>
            <a class="card-link" href="{{ route('playground.matrix.resource.boards') }}">View Boards</a>
        </div>
        @if ($dashboard->hasLinks('Board'))
        <ul class="list-group list-group-flush">
            @foreach ($dashboard->getLinks('Board') as $link)
            <li class="list-group-item">
                <a href="{{$link->uri}}" alt="{{$link->description ?? ''}}">
                    {{$link->label}}
                </a>
            </li>
            @endforeach
        </ul>
        @endif
    </div>
</div>
