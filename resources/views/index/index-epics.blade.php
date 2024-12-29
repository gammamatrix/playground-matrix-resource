<div class="col-sm-6">
    <div class="card m-1">
        <div class="card-header">
            <h3>
                Epics
                <span class="badge rounded-pill text-bg-primary">
                    <?= $dashboard->getCount('Epic') ?>
                </span>
            </h3>
        </div>
        <div class="card-body">
            <p class="card-text"></p>
            <a class="card-link" href="{{ route('playground.matrix.resource.epics') }}">View Epics</a>
        </div>
        @if ($dashboard->hasLinks('Epic'))
        <ul class="list-group list-group-flush">
            @foreach ($dashboard->getLinks('Epic') as $link)
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
