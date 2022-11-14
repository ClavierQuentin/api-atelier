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

                <label>
                    Image d'illustration
                </label>

                {{-- Si une image est stockée en base, on l'affiche --}}
                @if(isset($categorie->image_id))
                <?php
                    $image = DB::select('select * from images where id = ?', [$categorie->image_id]);
                    $url = $image[0]->url;
                ?>

                    {{-- Image --}}
                    <div>
                        <img src="{{ asset('storage/'.$url) }}" alt="Image d'illustration" height="200" class=" border border-info p-1 m-2">
                    </div>

                @endif

                <label for="imageDL">Télécharger une nouvelle image</label>
                {{-- Fomulaire pour l'image --}}
                <input type="file" name="imageDL" class="form-control @if ($errors->any()) is-invalid @endif" accept="image/*">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <span>{{ $error }}</span>
                        @endforeach
                    </div>
                @endif

                <p>Ou</p>

                {{-- Choix image existante --}}
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalImage">Choisir une image existante</a>
                <div id="containerImage"></div>


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
    @include('modal.index_image')

@endsection
