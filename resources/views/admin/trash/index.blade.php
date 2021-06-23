@extends('admin.template')

@section('h1', 'Index de la corbeille')

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
    <div class="table-responsive">
        <table class="text-center table table-striped table-hover">
            <thead class="bg-gradient text-white">
                <th>Titre</th>
                <th>Image</th>
                <th>Catégorie</th>
                <th>Paramètres</th>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td><img src="{{ asset($post->image) }}" width="100" height="100" alt=""></td>
                        <td>{{ $post->category->name }}</td>
                        <td>
                            <a href="{{ route('admin.trash.posts.restore', $post->id) }}" class="btn btn-sm text-white btn-info">Restaurer</a>
                            <form action="{{ route('admin.trash.posts.delete', $post->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('delete')
                                <input type="submit" value="Supprimer" class="btn btn-sm btn-danger" onclick="return confirm('Cette suppression est définitive. Continuer ?')"/>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection