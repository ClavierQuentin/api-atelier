@auth
    @extends('layouts.app')

    @section('title', 'Permission Error')

    @section('content')
        <div class="container-fluid">

            <!-- 404 Error Text -->
            <div class="text-center">
                <div class="error mx-auto" data-text="403">403</div>
                <p class="lead text-gray-800 mb-5">Permission Denied!</p>
                <p class="text-gray-500 mb-0">It looks like you don't Have Permission to access</p>
                <a href="{{ route('home') }}">← Back to home</a>
            </div>

        </div>
    @endsection
@endauth

