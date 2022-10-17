<!DOCTYPE html>

<html>

<head>

   <title></title>

</head>

<body>

    <h1>Nouveau message de {{ $details['prenom'] }} {{ $details['nom'] }}  '{{ $details['email'] }}'</h1>

   <h2>Sujet : {{ $details['sujet'] }}</h2>

   <p>{{ $details['message'] }}</p>


</body>

</html>
