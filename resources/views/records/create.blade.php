@extends('templates.main')
@section('content')
    <x-crud.header>Nový záznam</x-crud.header>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="individual-tab" data-bs-toggle="tab" data-bs-target="#individual" type="button"
                role="tab" aria-controls="individual" aria-selected="true">individuální</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="group-tab" data-bs-toggle="tab" data-bs-target="#group" type="button"
                role="tab" aria-controls="group" aria-selected="false">Skupinová</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                role="tab" aria-controls="contact" aria-selected="false">Kontakt</button>
        </li>
    </ul>
    <div class="tab-content mt-3" id="myTabContent">
        <div class="tab-pane fade show active" id="individual" role="tabpanel" aria-labelledby="home-tab">
            @include('forms.record-individual-form')
        </div>
        <div class="tab-pane fade" id="group" role="tabpanel" aria-labelledby="profile-tab">
            @include('forms.record-group-form')
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            @include('forms.record-contact-form')
        </div>
    </div>


@endsection
