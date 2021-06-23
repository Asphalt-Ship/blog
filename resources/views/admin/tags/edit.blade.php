@extends('admin.template')

@section('h1')
    Modifier : {{ $tag->name }}
@endsection

@section('mycontent')

    <div class="container my-5">
        <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST">
            @csrf
            @method('put')

            <div class="form-group">
                <label for="name">Nom :</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $tag->name }}"/>
                <div class="text-danger">{{ $errors->first("name", ":message") }}</div>
            </div>
            <div class="form-group text-center">
                <input type="submit" class="btn btn-success">
            </div>
        </form>
    </div>

@endsection