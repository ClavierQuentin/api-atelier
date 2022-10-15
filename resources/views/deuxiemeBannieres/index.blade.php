@extends('layouts.app')

@section('content')

    <div class="container">

        {{-- Fenetre d'erreur --}}
        @if (session('error'))
            <div class="alert alert-success">
                {{ session('error') }}
            </div>
        @endif

        <ul class="navbar-nav ">
            <li class="nav-item">
                <a href="{{ route('deuxiemeBanniere.create') }}" class="nav-link border d-inline m-2 p-1">Créer des nouvelles entrées</a>
            </li>
        </ul>

        {{-- Controle du nombre d'entrées en base --}}
        @if(sizeof($deuxiemeBannieres) > 0)

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

                    {{-- Parcours de toutes les entrées --}}
                    @foreach ($deuxiemeBannieres as $item)

                        <tr>
                            <td>{{ $item->id }}</td>

                            <td>
                                <a href="{{ route('deuxiemeBanniere.edit',['deuxiemeBanniere'=>$item]) }}"class="nav-link">{{ $item->titre }}</a>
                            </td>

                            <td>{{ date('d/m/Y h:i:s', strtotime($item->created_at))  }}</td>

                            <td>{{ date('d/m/Y h:i:s', strtotime($item->updated_at)) }}</td>

                            <td>
                                <a href="{{ route('deuxiemeBanniere.edit',['deuxiemeBanniere'=>$item]) }}"class="nav-link">
                                    <img  src="{{ asset('assets/edit.svg') }}" alt="icone d'édition" title="Mettre à jour">
                                </a>
                            </td>

                            <td>
                                <form action="{{ route('deuxiemeBanniere.delete',['deuxiemeBanniere'=>$item]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="trash"><img  src="{{ asset('assets/trash.svg') }}" alt="icone corbeille" title="Supprimer"></button>
                                </form>
                            </td>


                            <td>
                                <form action="{{ route('deuxiemeBanniere.online',['deuxiemeBanniere'=>$item]) }}" method="POST">
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
