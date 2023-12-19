<div>
    @if(Session::has('message'))
        <p class="alert {{Session::has('status') ? 'alert-'.Session::get('status') : 'alert-info'}}">{!! Session::get('message') !!}</p>
    @endif
</div>
