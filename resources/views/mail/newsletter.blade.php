<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8"><title>{{$newsletter['titre']}}</title>

</head>

<body>

{{-- Template de la newsletter --}}

    {{-- Données du body en dur créées via l'éditeur de texte pour mise en forme --}}
   {!! $newsletter["body"] !!}


   {{-- Lien pour désinscription avec id unique en param --}}
   <p style="font-size: 10px; font-style: italic; ">Si vous souhaitez vous désinscrire de la newsletter, <a href="https://api-atelier.herokuapp.com/edit-email?id={{ $id }}" target="_blank">Cliquez sur ce lien</a></p>

</body>

</html>
