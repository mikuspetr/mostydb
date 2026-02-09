<div class="card my-2">
    <div class="card-header">
        <div class="row">
        <div class="col-sm-2">
            <span class="mx-4">{{ Carbon\Carbon::parse($ip->date)->format('j. n. Y') }}</span>
        </div>
        <div class="col-sm-8">
            <h4>{!! $ip->title !!}</h4>
        </div>
        <div class="col-sm-2">
            @can('update')
            <a class="btn btn-outline-primary btn-sm float-end" href="{{route('individual-plans.edit', ['individual_plan' => $ip->id])}}" title="upravit"><i class="bi bi-pencil"></i> upravit IP</a>
            @endcan
        </div>
    </div>
    </div>
    <div class="card-body">
        <p class="card-text">{!! $ip->text !!}</p>
    </div>
</div>
