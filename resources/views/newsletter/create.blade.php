@extends('layouts.app')

@section('content')

{{-- Formulaire de création --}}
    <form action="{{ route('newsletter.store') }}" style="width: 90%; margin: auto;" method="POST">
        @csrf

        <div class="form-group mt-2">

            <label for="titre">Titre de la campagne d'email</label>
            <input class="form-control @error('titre') is-invalid @enderror" value="{{ old('titre') }}" type="text" name="titre" id="titre">

            @error('titre')
                <div class="alert alert-danger m-1">{{ $message }}</div>
            @enderror

        </div>

        <div class="form-group mt-2">

            <label for="editeur">Message de la campagne</label>
            <textarea name="body" id="editeur" rows="30" class="@error('body') is-invalid @enderror">{{ old('body') }}</textarea>

            @error('body')
                <div class="alert alert-danger m-1">{{ $message }}</div>
            @enderror



        </div>

        <button class="btn btn-info mt-2">Valider</button>

    </form>

@endsection
