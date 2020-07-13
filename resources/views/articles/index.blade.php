@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row justify-content-end my-3">
                <a href="{{ route('articles.create') }}" class="btn btn-success">Post new article</a>
            </div>
            @foreach ($articles as $article)
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <a class="text-decoration-none" href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a>
                        <div class="d-flex justify-content-around">
                            @can('update',$article)
                                <a href="{{route('articles.edit',$article->id)}}" class="btn btn-warning mx-2">Edit</a>
                            @endcan
                            @can('delete',$article)
                                <form method="POST" action="{{route('articles.destroy',$article->id)}}" >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger mx-2" >Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p> {{ $article->content }}</p>
                            <footer class="blockquote-footer"><cite title="Source Title">{{ $article->author->name }}</cite></footer>
                        </blockquote>
                    </div>
                    <div class="card-footer">
                        Tag: {{ $article->tag }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
