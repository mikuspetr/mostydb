@extends('templates.main')
@section('content')
<div class="row">
    <div class="col-sm-2 scrolling">
        @foreach($clients as $cl)
        <div id="client-{{ $cl->id}}">
            <a class="btn btn-outline-primary btn-sm w-100 {{$cl->id == $client->id ? 'active' : ''}}" href="{{route('clients.edit', ['client' => $cl->id])}}">
                {{$cl->clientCode}}
            </a>
        </div>
        @endforeach
    </div>
    <div class="col-sm-9">
        <h2>{{$client->clientCode}}</h2>
        <div>{!!$client->description->first_contact!!}</div>
        <div>{!!$client->description->personal!!}</div>
        <div>{!!$client->description->social!!}</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const element = document.getElementById("client-{{$client->id}}");
    element.scrollIntoView({behavior: 'smooth'});
</script>
@endpush
