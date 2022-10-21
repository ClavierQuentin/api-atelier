<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    {{-- Composants pour configurer l'éditeur de texte --}}
    @include('components.head.tinymce-config')

</head>


<form method="POST" class="custom-form" action="{{ route('email.delete') }}">
    @csrf
    <div class="form-group">
        <label for="email">Indiquez votre email</label>
        <input type="email" name="email" id="email" class="form-control">
    </div>
    <button>Se désinscrire</button>
</form>

</html>
