@extends('layouts.app')

@section('content')

{{-- Formulaire inexploitable pour afficher le détail de l'entrée --}}
    <form style="width: 90%; margin: auto;">

        {{-- Titre --}}
        <div class="form-group mt-2">
            <input type="text"  disabled class="form-control" value="{{ $newsletter->titre }}">
        </div>

        {{-- Corps du mail --}}
        <div class="form-group mt-2">
            <textarea id="editeur" class="form-control" disabled rows="30" cols="10">{{ $newsletter->body }}</textarea>
        </div>

    </form>

@endsection
