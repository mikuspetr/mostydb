<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('templates.head')

    <body>
        @include('templates.menu')
        @hasSection('content')
            <section id="app" class="container-fluid">
                @yield('content')
            </section>
        @endif

    </body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>

    <script>
        document.querySelectorAll('.ckeditor').forEach((node, index) => {
            ClassicEditor
                .create(node, {})
                .then(newEditor => {
                    window.editors[index] = newEditor
                });
        });
    </script>
    @stack('scripts')
</html>
