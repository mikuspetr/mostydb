<div class="card my-2">
    <div class="card-header">
        <div class="row">
        <div class="col-sm-2">
            <span class="mx-4">{{ Carbon\Carbon::parse($ip->date)->format('j. n. Y') }}</span>
        </div>
        <div class="col-sm-10">
            <h4>{!! $ip->title !!}</h4>
        </div>
    </div>
    </div>
    <div class="card-body">
        <p class="card-text">{!! $ip->text !!}</p>
    </div>
</div>
