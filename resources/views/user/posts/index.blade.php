@extends('user.template')

@section('datatables')
    {{-- datatables va nous permettre de créer des tables plus pratiques --}}
    {{-- on a téléchargé la version pour BS-4 --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.25/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.25/datatables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#table').DataTable();
                // il faut assigner cet ID au tableau
        });
    </script>
@endsection

@section('h1', "Index des articles")

@section('mycontent')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {!! session('success') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>      
    @endif

    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {!! session('warning') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>      
    @endif

    {{-- liste pour afficher les données --}}
    {{-- pour permettre ça, on a fait un get() dans la fonction index() du controller --}}
    <div class="table-responsive mt-5">
        <table id="table" class="text-center table table-striped table-hover">
            <thead class="bg-gradient text-white">
                <th>Titre</th>
                <th>Image</th>
                <th>Catégorie</th>
                <th>Contenu</th>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td><img src="{{ asset($post->image) }}" width="100" height="100" alt=""></td>
                        <td>{{ $post->category->name }}</td>
                            {{-- on fait appel à la fonction du modèle, et on lui passe le nom --}}
                            {{-- ça nous renvoie le nom de la catégorie au lieu de l'id --}}
                        <td>
                            <a href="{{ route('user.posts.show', $post->id) }}" class="btn btn-sm btn-info text-white">Lire</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


@endsection