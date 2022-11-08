@extends('layouts.app')

@section('content')
    <div class="container">
        <form  class="custom-form" action="{{ route('image.store') }}" method="POST"  enctype="multipart/form-data">
            @csrf

            <div class="form-group mt-2">
                <label for="image">Télécharger une ou plusieurs images</label>
                <input type="file" accept="image/*" multiple id="image" name="image[]" class="form-control @if ($errors->any()) is-invalid @endif" required>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <span>{{ $error }}</span>
                    @endforeach
                </div>
            @endif

            <button class="btn btn-info mt-2">Valider</button>
        </form>

    </div>
@endsection
