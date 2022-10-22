@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Back-Office Atelier Ginette</div>

                <div class="card-body">
                    @auth
                        <div class="alert alert-success" role="alert">
                            Bienvenue {{ Auth::user()->name }}
                        </div>
                    @endauth

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
