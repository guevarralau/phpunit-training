@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-end my-3">
                    <a href="{{route('articles.index')}}" class="btn btn-primary">Back to Articles</a>
                </div>
                <div class="card">
                    <div class="card-header">Update article</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('articles.update',['article' => $article->id]) }}">
                            @method('PATCH')
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Title</label>
                                <div class="col-md-6">
                                    <input
                                        id="title"
                                        type="text"
                                        class="form-control @error('title') is-invalid @enderror"
                                        name="title"
                                        value="{{ $article->title }}"
                                        autofocus
                                    />

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Content</label>

                                <div class="col-md-6">
                                <textarea
                                    id="content"
                                    type="text"
                                    rows="5"
                                    class="form-control @error('content') is-invalid @enderror"
                                    name="content"
                                    value="{{ $article->content }}"
                                >{{$article->content}}</textarea>

                                    @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Tag</label>

                                <div class="col-md-6">
                                    <select name="tag" id="tag" class="form-control">
                                        <option
                                            value="" disabled
                                            {{$article->tag ? '' : 'selected'}}
                                        >Select a tag</option>
                                        <option
                                            value="Food"
                                            {{$article->tag === 'Food' ? 'selected' : ''}}
                                        >Food</option>
                                        <option
                                            value="Travel"
                                            {{$article->tag === 'Travel' ? 'selected' : ''}}
                                        >Travel</option>
                                        <option
                                            value="Technology"
                                            {{$article->tag === 'Technology' ? 'selected' : ''}}
                                        >Technology</option>
                                    </select>

                                    @error('tag')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

