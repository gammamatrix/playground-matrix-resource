<div class="col-sm-6">
    <div class="card m-1">
        <div class="card-header">
            <h3>
                Notes
                <span class="badge rounded-pill text-bg-primary">
                    <?= $dashboard->getCount('Note') ?>
                </span>
            </h3>
        </div>
        <div class="card-body">
            <p class="card-text"></p>
            <a class="card-link" href="{{ route('playground.matrix.resource.notes') }}">View Notes</a>
        </div>
        @if ($dashboard->hasLinks('Note'))
        <ul class="list-group list-group-flush">
            @foreach ($dashboard->getLinks('Note') as $link)
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
