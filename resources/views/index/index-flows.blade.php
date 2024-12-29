<div class="col">
    <div class="card m-1">
        <div class="card-header">
            <h3>
                Project Workflows
                <span class="badge rounded-pill text-bg-primary">
                    <?= $dashboard->getCount('Flow') ?>
                </span>
            </h3>
        </div>
        <div class="card-body">
            <p class="card-text"></p>
            <a class="card-link" href="{{ route('playground.matrix.resource.flows') }}">View Flows</a>
        </div>
        @if ($dashboard->hasLinks('Flow'))
        <ul class="list-group list-group-flush">
            @foreach ($dashboard->getLinks('Flow') as $link)
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
