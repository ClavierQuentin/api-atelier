<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
   <title></title>

</head>

<body>

{{-- Template pour mail vers cliente lors d'un message de contact --}}

    <h1>Nouveau message de {{ $details['prenom'] }} {{ $details['nom'] }}  '{{ $details['email'] }}'</h1>

   <h2>Sujet : {{ $details['sujet'] }}</h2>

   <p>{{ $details['message'] }}</p>


</body>

</html>
