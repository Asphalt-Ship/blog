@extends('admin.template')

@section('summernote')
    {{-- summernote va permettre d'écrire des articles beaucoup plus facilement et efficacement --}}
    {{-- une partie script doit se situer juste après le textarea --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
@endsection

@section('h1')
    Modifier : {{ $post->title }}
@endsection

@section('mycontent')

    <div class="container my-5">
        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                {{-- cet 'enctype' est nécessaire pour le traitement des inputs de type 'file' --}}
            @csrf
            @method('patch')
            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $post->title }}"/>
                <div class="text-danger">{{ $errors->first("title", ":message") }}</div>
            </div>
            <div class="form-group">
                <label for="category_id">Catégorie</label>
                <select name="category_id" id="category_id" class="form-control">
                    {{-- pour afficher les catégories, il faut revenir au controller --}}
                    {{-- aussi, on ne peut pas retourner une value old() pour un select --}}
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $post->category_id ? 'selected' : '' }} >{{ $category->name }}</option>
                            {{-- on indique l'id pour faciliter le bon fonctionnement du back-end --}}
                    @endforeach
                        {{-- cette page bug sur le foreach parce qu'on n'a pas lié les catégories --}}
                </select>
                <div class="text-danger">{{ $errors->first("category_id", ":message") }}</div>
            </div>
            <div class="d-sm-flex justify-content-around align-items-center my-3">
                <div>
                    <p>Image actuelle</p>
                    <img src="{{ asset($post->image) }}" width="120" height="120">
                </div>
                <div>
                    <label for="image">Nouvelle image</label>
                    <input type="file" name="image" id="image" class="form-control-file"/>
                        {{-- impossible de retourner une value old() pour une image --}}
                        {{-- du coup on a importé ça dans le controller --}}
                    <div class="text-danger">{{ $errors->first("image", ":message") }}</div>
                </div>
            </div>
            <div class="form-group">
                <label for="content">Contenu</label>
                <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{ $post->content }}</textarea>
                {{-- insertion du script nécessaire à summernote. Il faut lui lier l'ID --}}
                <script>
                    $('#content').summernote({
                        placeholder: 'Entrez votre article ici',
                        tabsize: 2,
                        height: 100
                    });
                </script>
                <div class="text-danger">{{ $errors->first("content", ":message") }}</div>
            </div>
            <div class="form-group text-center">
                <input type="submit" class="btn btn-success" value="Sauvegarder"/>
            </div>
        </form>
    </div>

@endsection