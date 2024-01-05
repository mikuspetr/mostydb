@extends('templates.main')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <x-session-alert></x-session-alert>
            <x-crud.header itemId="{{$client->id}}">
                {{ $client->clientCode }}
            </x-crud.header>

            <div id="exTab2" class="clearfix my-3">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#int" data-bs-toggle="tab">
                            Intervence <span class="badge text-bg-primary">{{$records->count()}}</span>
                        </a>
                    </li>
                    <li class="nac-item">
                        <a class="nav-link" href="#ip" data-bs-toggle="tab">
                            Individuální plány <span class="badge text-bg-primary">{{$IPs->count()}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#anamneza" data-bs-toggle="tab">
                            Anamnéza
                        </a>
                    </li>
                </ul>

                <div class="tab-content ">
                    <div class="tab-pane my-3 active" id="int">
                        @foreach ($records as $record)
                            <x-record-card :record="$record" />
                        @endforeach
                    </div>
                    <div class="tab-pane my-3" id="ip">
                        @foreach ($IPs as $ip)
                            <x-ip-card :ip="$ip" />
                        @endforeach
                    </div>
                    <div class="tab-pane my-3" id="anamneza">
                        <h4>První kontakt</h4>
                        <p>{!! $client->description->first_contact !!}</p>
                        <hr>
                        <h4>Osobní</h4>
                        <p>{!! $client->description->personal !!}</p>
                        <hr>
                        <h4>Sociální</h4>
                        <p>{!! $client->description->social !!}</p>
                        <hr>
                    </div>
                </div>
            </div>

            <div class="clearfix">

            </div>
        </div>
    </div>
@endsection
