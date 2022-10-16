@extends('layouts.app')

@section('content')

    {{-- Contenu de la premiére banniere --}}
    <div class="container mb-5">

        <h2 class="m-2 text-success">Première bannière</h2>

        {{-- On controle le nombre d'entrées en base --}}
        @if(isset($premiereBannieres) && sizeof($premiereBannieres) > 0)

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

                    {{-- Parcours de toutes les entrées de premiereBannieres --}}
                    @foreach ($premiereBannieres as $item)

                        <tr>
                            <td>{{ $item->id }}</td>

                            <td>
                                <a href="{{ route('premiereBanniere.index') }}"class="nav-link">{{ $item->titre }}</a>
                            </td>

                            <td>{{ date('d/m/Y h:i:s', strtotime($item->created_at))  }}</td>

                            <td>{{ date('d/m/Y h:i:s', strtotime($item->updated_at)) }}</td>

                            <td>
                                <a href="{{ route('premiereBanniere.edit',['premiereBanniere'=>$item->id]) }}"class="nav-link">
                                    <img  src="{{ asset('assets/edit.svg') }}" alt="Icone édition" title="Mettre à jour">
                                </a>
                            </td>

                            <td>
                                <form action="{{ route('premiereBanniere.delete',['premiereBanniere'=>$item->id]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="trash"><img  src="{{ asset('assets/trash.svg') }}" alt="icone corbeille" title="Supprimer"></button>
                                </form>
                            </td>

                            <td>
                                <form action="{{ route('premiereBanniere.online',['premiereBanniere'=>$item->id]) }}" method="POST">
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


        <ul class="navbar-nav me-auto">
            <li class="nav-item  m-2">
                <a href="{{ route('premiereBanniere.index') }}" class="nav-link border border-info d-inline p-2">En voir plus</a>
            </li>
        </ul>

    </div>
    {{-- Fin premiere bannièere --}}

    {{-- Contenu deuxieme banniere --}}
    <div class="container  mb-5">

        <h2  class="m-2 text-success">Deuxième bannière</h2>

        {{-- Controle du nombre de données en base --}}
        @if(isset($deuxiemeBannieres) && sizeof($deuxiemeBannieres) > 0)
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
                    @foreach ($deuxiemeBannieres as $item)

                        <tr>
                            <td>{{ $item->id }}</td>

                            <td>
                                <a href="{{ route('deuxiemeBanniere.index') }}" class="nav-link">{{ $item->titre }}</a>
                            </td>

                            <td>{{ date('d/m/Y h:i:s', strtotime($item->created_at))  }}</td>

                            <td>{{ date('d/m/Y h:i:s', strtotime($item->updated_at)) }}</td>

                            <td>
                                <a href="{{ route('deuxiemeBanniere.edit',['deuxiemeBanniere'=>$item->id]) }}"class="nav-link">
                                    <img  src="{{ asset('assets/edit.svg') }}" alt="icone d'édition" title="Mettre à jour">
                                </a>
                            </td>

                            <td>
                                <form action="{{ route('deuxiemeBanniere.delete',['deuxiemeBanniere'=>$item->id]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="trash"><img  src="{{ asset('assets/trash.svg') }}" alt="icone corbeille" title="Supprimer"></button>
                                </form>
                            </td>

                            <td>
                                <form action="{{ route('deuxiemeBanniere.online',['deuxiemeBanniere'=>$item->id]) }}" method="POST">
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

        <ul class="navbar-nav me-auto">
            <li class="nav-item  m-2">
                <a href="{{ route('deuxiemeBanniere.index') }}" class="nav-link border border-info d-inline p-2">En voir plus</a>
            </li>
        </ul>

    </div>
    {{-- Fin deuxieme banniere --}}

    {{-- Contenu troisieme banniere --}}
    <div class="container">

        <h2 class="m-2 text-success">Troisième bannière</h2>

        {{-- Controle du nombre d'entrée en base --}}
        @if(isset($troisiemeBannieres) && sizeof($troisiemeBannieres) > 0)
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

                    {{-- Parcours de toutes entrées --}}
                    @foreach ($troisiemeBannieres as $item)

                        <tr>
                            <td>{{ $item->id }}</td>

                            <td>
                                <a href="{{ route('troisiemeBanniere.index') }}"class="nav-link">{{ $item->titre_principal }}</a>
                            </td>

                            <td>{{ date('d/m/Y h:i:s', strtotime($item->created_at))  }}</td>

                            <td>{{ date('d/m/Y h:i:s', strtotime($item->updated_at)) }}</td>

                            <td>
                                <a href="{{ route('troisiemeBanniere.edit',['troisiemeBanniere'=>$item->id]) }}"class="nav-link">
                                    <img  src="{{ asset('assets/edit.svg') }}" alt="icone d'édition" title="Mettre à jour">
                                </a>
                            </td>

                            <td>
                                <form action="{{ route('troisiemeBanniere.delete',['troisiemeBanniere'=>$item->id]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="trash"><img  src="{{ asset('assets/trash.svg') }}" alt="Icone corbeille" title="Supprimer"></button>
                                </form>
                            </td>

                            <td>
                                <form action="{{ route('troisiemeBanniere.online',['troisiemeBanniere'=>$item->id]) }}" method="POST">
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

        <ul class="navbar-nav me-auto">
            <li class="nav-item  m-2">
                <a href="{{ route('troisiemeBanniere.index') }}" class="nav-link border border-info d-inline p-2">En voir plus</a>
            </li>
        </ul>

    </div>
    {{-- Fin troisieme banniere --}}

@endsection
