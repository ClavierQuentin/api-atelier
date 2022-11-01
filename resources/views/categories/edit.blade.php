@extends('layouts.app')

@section('content')

    <div class="container">

        {{-- Formulaire d'édition --}}
        <form class="custom-form" action="{{ route('categorie.update',['categorie'=>$categorie]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="form-goup m-2">

                <label for="nom_categorie">
                    Nom de la catégorie
                </label>
                {{-- Formulaire pour le nom --}}
                <input type="text" name="nom_categorie" id="nom_categorie" class="form-control @error('nom_categorie') is-invalid @enderror" value="{{ $categorie->nom_categorie }}">

                @error('nom_categorie')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group m-2">

                <label for="image">
                    Image d'illustration
                </label>

                {{-- Si une image est stockée en base, on l'affiche --}}
                @if(isset($categorie->url_image_categorie))

                    {{-- Image --}}
                    <div class="border border-info p-1 m-2">
                        <img src="{{ $categorie->url_image_categorie }}" alt="Image d'illustration" height="200" class=" border-info">
                    </div>

                @endif

                {{-- Fomulaire pour l'image --}}
                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">

                @error('image')
                    <div class="alert alert-danger m-1">{{ $message }}</div>
                @enderror


            </div>

            <div class="form-group m-3">

                {{-- Checkbox pour mise en avant en page d'accueil --}}
                <div class="form-check">
                    <input type="checkbox" name="isAccueil" id="isAccueil" class="form-check-input @if ($errors->any()) is-invalid @endif" @if($categorie->isAccueil == 1) checked = 'true'  @endif value = "1">
                    <label for="isAccueil" class="form-check-label">Mettre en avant sur l'accueil</label>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <span>{{ $error }}</span>
                            @endforeach
                        </div>
                    @endif

                </div>

            </div>


            <button class="btn btn-info m-2">Valider</button>

        </form>

    </div>

@endsection
