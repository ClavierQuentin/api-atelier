@extends('layouts.app')

@section('content')

    <div class="container">

        {{-- Fenetre d'erreur --}}
        @if (session('error'))
            <div class="alert alert-success">
                {{ session('error') }}
            </div>
        @endif

        {{-- Lien formulaire création --}}
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="{{ route('troisiemeBanniere.create') }}" class="nav-link border d-inline m-2 p-1">Créer des nouvelles entrées</a>
            </li>
        </ul>

        {{-- Controle du nombre d'entrée en base --}}
        @if(isset ($troisiemeBannieres) && sizeof($troisiemeBannieres) > 0)

            {{-- Tableau --}}
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

                    {{-- Parcours de toutes les entrées --}}
                    @foreach ($troisiemeBannieres as $item)

                        <tr>
                            {{-- ID --}}
                            <td>{{ $item->id }}</td>

                            {{-- Titre + lien édition --}}
                            <td>
                                <a href="{{ route('troisiemeBanniere.edit',['troisiemeBanniere'=>$item]) }}"class="nav-link">{{ $item->titre_principal }}</a>
                            </td>

                            {{-- Date création --}}
                            <td>{{ date('d/m/Y h:i:s', strtotime($item->created_at))  }}</td>

                            {{-- Date MAJ --}}
                            <td>{{ date('d/m/Y h:i:s', strtotime($item->updated_at)) }}</td>

                            {{-- Icone + lien édition --}}
                            <td>
                                <a href="{{ route('troisiemeBanniere.edit',['troisiemeBanniere'=>$item->id]) }}"class="nav-link">
                                    <img  src="{{ asset('assets/edit.svg') }}" alt="icone d'édition" title="Mettre à jour">
                                </a>
                            </td>

                            {{-- Icone + formulaire suppression --}}
                            <td>
                                <form action="{{ route('troisiemeBanniere.delete',['troisiemeBanniere'=>$item->id]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="trash"><img  src="{{ asset('assets/trash.svg') }}" alt="Icone corbeille" title="Supprimer"></button>
                                </form>
                            </td>

                            {{-- Bouton mise en avant site vitrine --}}
                            <td>
                                <form action="{{ route('troisiemeBanniere.online',['troisiemeBanniere'=>$item]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-secondary @if($item->online == 1) btn-danger @endif">Online</button>
                                </form>
                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

            {{-- pagination --}}
            {!! $troisiemeBannieres->links() !!}

        @else

            <div class="border border-danger text-center m-4">
                Il n'y a aucune donnée à afficher
            </div>

        @endif

    </div>

@endsection
