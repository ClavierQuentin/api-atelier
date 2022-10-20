@extends('layouts.app')

@section('content')

    <form action="{{ route('newsletter.store') }}" class="custom-form" method="POST">
        @csrf

        <div class="form-group mt-2">

            <label for="titre">Titre de la campagne d'email</label>
            <input class="form-control" type="text" name="titre" id="titre">

        </div>

        <div class="form-group mt-2">

            <label for="editeur">Message de la campagne</label>
            <textarea name="body" id="editeur" ></textarea>

        </div>

        <button class="btn btn-info mt-2">Valider</button>

    </form>

@endsection
