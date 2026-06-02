@extends('templates.main')
@section('content')
<x-crud.header>Úprava individuálního plánu č. {{$plan->id}}</x-crud.header>
<div class="row">
    <div class="col-lg-8">
        <form method="POST" action="{{ route('individual-plans.update', $plan->id) }}">
            @csrf
            @method('PUT')
            <ip-form
                :plan="{{ $plan }}"
                :clients="{{ json_encode($clients) }}"
            ></ip-form>
        {{--
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="date" class="form-label">Datum</label>
                    <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror"
                           value="{{ old('date', $plan->date) }}">
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="client_id" class="form-label">Klient <span class="text-danger">*</span></label>
                    <select name="client_id" id="client_id" class="form-select @error('client_id') is-invalid @enderror" required>
                        <option value="">Vyberte klienta</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id', $plan->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->clientCode }}
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="title" class="form-label">Název plánu</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $plan->title) }}" maxlength="255">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="text" class="form-label">Obsah plánu</label>
                    <textarea name="text" id="text" class="form-control ckeditor @error('text') is-invalid @enderror"
                              rows="10">{{ old('text', $plan->text) }}</textarea>
                    @error('text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        --}}

            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Uložit změny
                    </button>
                    <a href="{{ route('individual-plans.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Zrušit
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

