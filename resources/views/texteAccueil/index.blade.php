@extends('layouts.app')

@section('content')

    <div class="container">

        {{-- Lien formulaire création --}}
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a href="{{ route('texteAccueil.create') }}" class="nav-link border d-inline m-2 p-1">Créer des nouvelles entrées</a>
            </li>
        </ul>

        {{-- Controle du nombre de données en base --}}
        @if(isset($data) && sizeof($data) > 0)

            {{-- tableau --}}
            <table class="table m-1">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            Titre
                        </th>
                        <th>
                            Date création
                        </th>
                        <th>
                            Date mise à jour
                        </th>
                        <th>
                            Editer
                        </th>
                        <th>
                            Supprimer
                        </th>
                        <th>
                            Mettre en avant
                        </th>
                    </tr>
                </thead>

                <tbody>

                    {{-- On parcours les entrée --}}
                    @foreach ($data as $item)

                        <tr>
                            {{-- ID --}}
                            <td>{{ $item->id }}</td>

                            {{-- Titre + lien édition --}}
                            <td><a href="{{ route('texteAccueil.edit',['texteAccueil'=>$item]) }}"class="nav-link">{{ $item->titre_accueil }}</a></td>

                            {{-- Date création --}}
                            <td>{{ $item->created_at->format('d/m/Y h:i:s') }}</td>

                            {{-- Date MAJ --}}
                            <td>{{ $item->updated_at->format('d/m/Y h:i:s') }}</td>

                            {{-- Icone + lien édition --}}
                            <td>
                                <a href="{{ route('texteAccueil.edit',['texteAccueil'=>$item]) }}"class="nav-link">
                                    <img  src="{{ asset('assets/edit.svg') }}" alt="icone d'édition" title="Mettre à jour">
                                </a>
                            </td>

                            {{-- Icone + formulaire suppression --}}
                            <td>
                                <form action="{{ route('texteAccueil.delete',['texteAccueil'=>$item]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="trash"><img  src="{{ asset('assets/trash.svg') }}" alt="icone corbeille" title="Supprimer"></button>
                                </form>
                            </td>

                            {{-- Bouton mise en avant site vitrine --}}
                            <td>
                                <form action="{{ route('texteAccueil.online',['texteAccueil'=>$item]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-secondary @if($item->online == 1) btn-danger @endif">Online</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>

            {{-- Pagination --}}
            {!! $data->links() !!}

        @else

            <div class="border border-danger text-center m-4">
                Il n'y a aucune donnée à afficher
            </div>

        @endif

    </div>

@endsection
