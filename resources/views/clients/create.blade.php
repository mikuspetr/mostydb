@extends('templates.main')
@section('content')
    <x-crud.header btnText='Přehled kientů'>Přidat nového klienta</x-crud.header>
    @include('forms.client-form')
@endsection

@push('scripts')
    <script>
        $(document).on('change', 'input[name=client_status]', function(){
            if($(this).val() == 2){
                $('#contract').attr('disabled', 'disabled');
            } else {
                $('#contract').removeAttr('disabled');
            }
        });
        $(document).on('change', '#orp', function(){
            axios.get('/get-municipalities/' + $(this).val())
            .then(function (response) {
                var html = '<option value=""><span class="text-danger">Vyberte obec</span></option>';
                $.each(response.data.data, function(id, municipality){
                    html = html + '<option value="'+municipality.id+'">'+municipality.name+'</option>';
                });
                $('#municipality').html(html);
                console.log(response.data.data);
            });
        });

    </script>

@endpush
