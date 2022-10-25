{{-- Template pour formulaire de suppression des addresse email coté client --}}

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

</head>

<body>
    <form method="POST" class="custom-form" action="{{ route('email.delete') }}">
        @csrf
        {{-- On incorpore l'id unique au formulaire, récupéré via l'url --}}
        <input type="hidden" name="identifiant" value={{$token}}>
        <div class="form-group">
            <label for="email">Indiquez votre email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <button>Se désinscrire</button>
    </form>

</body>

</html>
