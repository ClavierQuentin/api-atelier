@extends('layouts.app')

@section('content')

    <form style="width: 90%; margin: auto;">

        <div class="form-group mt-2">
            <input type="text"  disabled class="form-control" value="{{ $newsletter->titre }}">
        </div>

        <div class="form-group mt-2">
            <textarea id="editeur" class="form-control" disabled rows="30" cols="10">{{ $newsletter->body }}</textarea>
        </div>

    </form>

@endsection
