<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('templates.head')

    <body class="bg-light">
        <main id="app" class="container py-4">
            <ebook-store
                :ebooks='@json($ebooks)'
                checkout-url="{{ route('orders.store') }}"
            ></ebook-store>
        </main>
    </body>
</html>
