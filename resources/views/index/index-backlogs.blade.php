<div class="col-sm-6">
    <div class="card m-1">
        <div class="card-header">
            <h2>
                Backlogs
                <span class="badge rounded-pill text-bg-primary">
                    <?= $dashboard->getCount('Backlog') ?>
                </span>
            </h2>
        </div>
        <div class="card-body">
            <p class="card-text"></p>
            <a class="card-link" href="{{ route('playground.matrix.resource.backlogs') }}">View Backlogs</a>
        </div>
        @if ($dashboard->hasLinks('Backlog'))
        <ul class="list-group list-group-flush">
            @foreach ($dashboard->getLinks('Backlog') as $link)
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
