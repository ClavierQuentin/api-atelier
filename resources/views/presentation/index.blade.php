@extends('layouts.app')

@section('content')

    {{-- Contenu de la premi�re banniere --}}
    <div class="container mb-5">

        <h2 class="m-2 text-success">Premi�re banni�re</h2>

        {{-- On controle le nombre d'entr�es en base --}}
        @if(sizeof($premiereBannieres) > 0)

            <table class="table m-1">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            Titre
                        </th>
                        <th>
                            Date cr�ation
                        </th>
                        <th>
                            Date mise a jour
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

                    {{-- Parcours de toutes les entr�es de premiereBannieres --}}
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
                                    <img  src="{{ asset('assets/edit.svg') }}" alt="Icone �dition" title="Mettre � jour">
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
                Il n'y a aucune donn�e � afficher
            </div>

        @endif


        <ul class="navbar-nav me-auto">
            <li class="nav-item  m-2">
                <a href="{{ route('premiereBanniere.index') }}" class="nav-link border border-info d-inline p-2">En voir plus</a>
            </li>
        </ul>

    </div>
    {{-- Fin premiere banni�ere --}}

    {{-- Contenu deuxieme banniere --}}
    <div class="container  mb-5">

        <h2  class="m-2 text-success">Deuxi�me banni�re</h2>

        {{-- Controle du nombre de donn�es en base --}}
        @if(sizeof($deuxiemeBannieres) > 0)
            <table class="table m-1">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            Titre
                        </th>
                        <th>
                            Date cr�ation
                        </th>
                        <th>
                            Date mise a jour
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

                    {{-- Parcours de toutes les entr�es --}}
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
                                    <img  src="{{ asset('assets/edit.svg') }}" alt="icone d'�dition" title="Mettre � jour">
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
                Il n'y a aucune donn�e � afficher
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

        <h2 class="m-2 text-success">Troisi�me banni�re</h2>

        {{-- Controle du nombre d'entr�e en base --}}
        @if(sizeof($troisiemeBannieres) > 0)
            <table class="table m-1">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            Titre
                        </th>
                        <th>
                            Date cr�ation
                        </th>
                        <th>
                            Date mise a jour
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

                    {{-- Parcours de toutes entr�es --}}
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
                                    <img  src="{{ asset('assets/edit.svg') }}" alt="icone d'�dition" title="Mettre � jour">
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
                Il n'y a aucune donn�e � afficher
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
