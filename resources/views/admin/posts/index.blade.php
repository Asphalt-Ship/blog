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
                <th>Publication</th>
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
                            <a href="{{ route('admin.posts.show', $post->id) }}" class="btn btn-sm btn-info text-white">Lire</a>
                        </td>
                        <td>
                            @if ($post->published == 1)
                                <div>
                                    Publié
                                </div>
                                <div>
                                    <small>Le {{ $post->published_at->format("d/m/Y à H:i:s") }}</small>
                                    {{-- pour permettre ce format de date, on passe par le modèle --}}
                                </div>
                            @else
                                <div>
                                    Non publié
                                </div>
                            @endif
                            {{-- {{ $post->published == 1 ? 'Publié' : 'Non publié'}} --}}
                            <form action="{{ route('admin.posts.published', $post->id) }}" method="POST">
                                @csrf
                                @method('put')
                                <div class="custom-control custom-switch my-2">
                                    <input type="checkbox" class="custom-control-input" name="published_input" id="switch-{{ $post->id }}" onchange="this.form.submit()" {{ $post->published == 1 ? 'checked' : '' }} />
                                        {{-- onchange est un attribut JS --}}
                                        {{-- on utilise un ternaire pour dire au toggle d'être checked ou non --}}
                                    <label class="custom-control-label" for="switch-{{ $post->id }}"></label>
                                        {{-- l'id ne change rien à l'affichage, mais permet de différencier en back-end --}}
                                </div> 
                            </form>                             
                        </td>
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