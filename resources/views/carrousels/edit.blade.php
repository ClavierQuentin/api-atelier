@extends('layouts.app')

@section('content')

{{-- Formulaire d'édition --}}
<div class="container">

    <form class="custom-form" action="{{ route('carrousel.update',['carrousel'=>$carrousel]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="form-group m2">

            <label for="editeur">
                Texte du carrousel
            </label>

            {{-- Editeur de texte --}}
            <textarea class="form-control @error('texte') is-invalid @enderror" name="texte" id="editeur" cols="10" rows="5">{{ $carrousel->texte }}</textarea>

            @error('texte')
                <div class="alert alert-danger m-1">{{ $message }}</div>
            @enderror

        </div>

        <div class="form-group m2">

            <label for="bouton">
                Intitulé du bouton
            </label>
            <input type="text" id="bouton" name="bouton" class="form-control @error('bouton') is-invalid @enderror" value="{{ $carrousel->bouton }}">

            @error('bouton')
                <div class="alert alert-danger m-1">{{ $message }}</div>
            @enderror

        </div>

        <div class="form-group m-2" id="divImage">

            <label>
                Image d'illustration
            </label>

            {{-- Si une image est stockée en base, on l'affiche --}}
            @if(isset($carrousel->image_id))
            <?php
                $image = DB::select('select * from images where id = ?', [$carrousel->image_id]);
                $url = $image[0]->url;
            ?>

                {{-- Image --}}
                <div>
                    <img src="{{ asset('storage/'.$url) }}" alt="Image d'illustration" height="200" class=" border border-info p-1 m-2">
                </div>

            @endif


            {{-- Formulaire pour l'image --}}
             <label for="image">
                     Télécharger une nouvelle image
             </label>
             <input type="file" name="imageDL"  class="form-control @if ($errors->any()) is-invalid @endif" accept="image/*">

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

         <div class="form-group m2">

            <label for="url">
                URL du bouton
            </label>
            <input type="url" pattern="https://.*" id="url" name="url" class="form-control @if ($errors->any()) is-invalid @endif" >

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <span>{{ $error }}</span>
                    @endforeach
                </div>
            @endif

        </div>

        <button class="btn btn-info m-2">Valider</button>

    </form>
    @include('modal.index_image')
</div>

@endsection
