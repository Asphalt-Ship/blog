@extends('user.template')

@section('h1')
    {{ $post->title }}
@endsection

@section('mycontent')

    <div class="container">
        {!! $post->content !!}
    </div>

    <div class="d-flex justify-content-end align-items-center m-5">
        <a href="{{ route('user.posts.index') }}" class="btn btn-primary">Retour</a>
    </div>

@endsection