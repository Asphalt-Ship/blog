@extends('admin.template')

@section('h1', "Index des tags")

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
        <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">Nouveau tag</a>
    </div>

    {{-- table pour lister les catégories --}}
    {{-- pour permettre ça, on a fait un get() dans la fonction index() du controller --}}
    <div class="table-responsive">
        <table class="text-center table table-striped table-hover">
            <thead class="bg-gradient text-white">
                <th>Nom</th>
                <th>Date de création</th>
                <th>Date de modification</th>
                <th>Paramètres</th>
            </thead>
            <tbody>
                @foreach ($tags as $tag)
                    <tr>
                        <td>{{ $tag->name }}</td>
                        <td>{{ $tag->created_at }}</td>
                        <td>{{ $tag->updated_at }}</td>
                        <td>
                            <a href="{{ route('admin.tags.edit', $tag->id) }}" class="btn btn-sm text-white btn-info">Modifier</a>
                            <form action="{{ route('admin.tags.delete', $tag->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('delete')
                                <input type="submit" value="Supprimer" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')"/>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- boutons de défilement --}}
    {{-- <div class="d-flex justify-content-end align items-center">
        {{ $categories->links() }} --}}
        {{-- on affiche les boutons de pagination pour les catégories --}}
        {{-- les boutons sont mal dimensionnés, on va dans app/Providers/AppServiceProvider.php --}}
    </div>
    
@endsection