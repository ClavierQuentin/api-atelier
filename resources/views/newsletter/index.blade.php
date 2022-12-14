@extends('layouts.app')

@section('content')

    <div class="container">

        {{-- Fenetre d'erreur --}}
        @if (session('error'))
            <div class="alert alert-success">
                {{ session('error') }}
            </div>
        @endif

        {{-- Controle du nombre d'entrée en base --}}
        @if(isset ($newsletters) && sizeof($newsletters) > 0)

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
                            Supprimer
                        </th>

                    </tr>
                </thead>

                <tbody>

                    {{-- Parcours de toutes les entrées --}}
                    @foreach ($newsletters as $item)

                        <tr>
                            {{-- ID --}}
                            <td>{{ $item->id }}</td>

                            {{-- Titre + lien détail --}}
                            <td>
                                <a href="{{ route('newsletter.show',['newsletter'=>$item->id]) }}"class="nav-link">{{ $item->titre }}</a>
                            </td>

                            {{-- Date de création --}}
                            <td>{{ date('d/m/Y h:i:s', strtotime($item->created_at))  }}</td>

                            {{-- Icone + formulaire de suppression --}}
                            <td>
                                <form action="{{ route('newsletter.delete',['newsletter'=>$item->id]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="trash"><img  src="{{ asset('assets/trash.svg') }}" alt="Icone corbeille" title="Supprimer"></button>
                                </form>
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

            {{-- Pagination --}}
            {!! $newsletters->links() !!}

        @else

            <div class="border border-danger text-center m-4">
                Il n'y a aucune donnée à afficher
            </div>

        @endif

    </div>

@endsection
