@extends('admin.template')

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

    <div class="d-flex justify-content-end align-items-center my-5">
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">Nouvel article</a>
    </div>

    {{-- liste pour afficher les données --}}
    {{-- pour permettre ça, on a fait un get() dans la fonction index() du controller --}}
    <div class="table-responsive">
        <table class="text-center table table-striped table-hover">
            <thead class="bg-gradient text-white">
                <th>Titre</th>
                <th>Image</th>
                <th>Catégorie</th>
                <th>Contenu</th>
                <th>Publié ?</th>
                <th>Paramètres</th>
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
                            <a href="" class="btn btn-sm btn-info text-white">Lire</a>
                        </td>
                        <td>{{ $post->published }}</td>
                        <td>
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm text-white btn-info">Modifier</a>
                            <form action="" method="POST" class="d-inline">
                                @csrf
                                <input type="submit" value="Corbeille" class="btn btn-sm btn-danger" onclick="return confirm('Déplacer cet article dans la corbeille ?')"/>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


@endsection