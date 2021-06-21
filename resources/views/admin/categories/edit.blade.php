@extends('admin.template')

@section('h1')
    Modifier : {{ $category->name }}
@endsection

@section('mycontent')

    <div class="container my-5">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('patch')
                {{-- la méthode 'put' est aussi acceptée --}}

            <div class="form-group">
                <label for="name">Nom :</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}"/>
                <div class="text-danger">{{ $errors->first("name", ":message") }}</div>
            </div>
            <div class="form-group text-center">
                <input type="submit" class="btn btn-success">
            </div>
        </form>
    </div>

@endsection