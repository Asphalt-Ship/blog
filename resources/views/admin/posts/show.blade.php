@extends('admin.template')

@section('h1')
    {{ $post->title }}
@endsection

@section('mycontent')

    <div class="container">
        {!! $post->content !!}
    </div>

@endsection