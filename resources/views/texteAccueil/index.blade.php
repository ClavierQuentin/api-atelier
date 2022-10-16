@extends('layouts.app')

@section('content')

    <div class="container">

        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a href="{{ route('texteAccueil.create') }}" class="nav-link border d-inline m-2 p-1">Créer des nouvelles entrées</a>
            </li>
        </ul>

        {{-- Controle du nombre de données en base --}}
        @if(isset($data) && sizeof($data) > 0)

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
                            <td>{{ $item->id }}</td>

                            <td><a href="{{ route('texteAccueil.edit',['texteAccueil'=>$item]) }}"class="nav-link">{{ $item->titre_accueil }}</a></td>

                            <td>{{ $item->created_at->format('d/m/Y') }}</td>

                            <td>{{ $item->updated_at->format('d/m/Y') }}</td>

                            <td>
                                <a href="{{ route('texteAccueil.edit',['texteAccueil'=>$item]) }}"class="nav-link">
                                    <img  src="{{ asset('assets/edit.svg') }}" alt="icone d'édition" title="Mettre à jour">
                                </a>
                            </td>

                            <td>
                                <form action="{{ route('texteAccueil.delete',['texteAccueil'=>$item]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="trash"><img  src="{{ asset('assets/trash.svg') }}" alt="icone corbeille" title="Supprimer"></button>
                                </form>
                            </td>

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

        @else

            <div class="border border-danger text-center m-4">
                Il n'y a aucune donnée à afficher
            </div>

        @endif

    </div>

@endsection
