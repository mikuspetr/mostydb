<script>
    $(document).on('change', 'input[name=client_type]', function(){
        if($(this).val() == 2){
            $('#contract').attr('disabled', 'disabled');
        } else {
            $('#contract').removeAttr('disabled');
        }
    });

    $(document).on('change', '#orp', function(){
        axios.get('/get-municipalities/' + $(this).val())
        .then(function (response) {
            var firstOption = response.data.data.length == 0 ? 'Neprve vyberte ORP' : 'Vyberte obec';
            var html = '<option value="">'+firstOption+'</option>';
            $.each(response.data.data, function(id, municipality){
                html = html + '<option value="'+municipality.id+'">'+municipality.name+'</option>';
            });
            $('#municipality').html(html);
        });
        $('#municipality').addClass('text-danger');
    });

    $(document).on('change', '#municipality', function(){
        if($(this).val() == '') {
            $(this).addClass('text-danger');
        }
        else {
            $(this).removeClass('text-danger');
        }
    });

    window.editors = {};

    document.querySelectorAll( '.ckeditor' ).forEach( ( node, index ) => {
        ClassicEditor
            .create( node, {} )
            .then( newEditor => {
                window.editors[ index ] = newEditor
            } );
    } );
</script>
