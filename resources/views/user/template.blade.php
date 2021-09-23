@extends('layouts.app')
    {{-- ce template importe le template de layouts/app.blade.php --}}

{{-- dashboard d'administration --}}
@section('content')
    <div class="row" style="margin:0;">
        <div class="col-md-2 bg-ocean text-center sidebar">
            <div class="list-group bg-ocean">
                <a href="{{ route('user.index') }}" class="list-group-item bg-ocean text-white">Accueil</a>
                <a href="{{ route('user.posts.index') }}" class="list-group-item bg-ocean text-white">Articles</a>
            </div>
        </div>
        <div class="col-md-10">
            {{-- le h1 --}}
            <h1 class="text-center text-primary my-3">
                @yield('h1')
            </h1>
            
            {{-- le contenu --}}
            @yield('mycontent')
        </div>
    </div>
@endsection
    {{-- cette section sera à l'endroit du @yield('content') dans layout.app --}}