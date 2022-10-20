{{-- Variable $_name en param pour nom de l'input --}}

    <textarea id="editeur" name="{{ $_name }}">@if(isset($produit->description_longue_produit)) {{ $produit->description_longue_produit }} @endif</textarea>

