@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-end my-3">
                <a href="{{route('articles.index')}}" class="btn btn-primary">Back to Articles</a>
            </div>
            <div class="card">

                <div class="card-header d-flex justify-content-between">
                    <span>{{ $article->title }}</span>
                    <span>{{ $article->author->name }}</span>
                </div>

                <div class="card-body">
                    {{ $article->content }}
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <div> {{ $article->tag }}</div>
                    <div class="d-flex justify-content-end">
                        @can('update',$article)
                            <a href="{{route('articles.edit' , [$article])}}" class="btn-sm btn btn-warning mx-2">Edit</a>
                        @endcan
                        @can('delete',$article)
                            <form method="POST" action="{{route('articles.destroy',$article->id)}}" >
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn-sm btn btn-danger mx-2" >Delete</button>
                            </form>
                        @endcan
                    </div>
                </div>
                <div>
                    <h5 class="font-weight-bold p-3">Comments</h5>
                    <div  class="d-flex flex-column">
                        @forelse($article->comments as $comment)
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <span class="ml-4 my-2">{{$comment->content}} - {{$comment->author->name}}</span>
                                <div class="d-flex justify-content-end align-items-center mx-3 my-2">
                                    @can('update',$comment)
                                        <button
                                            data-content="{{$comment->content}}"
                                            data-id="{{$comment->id}}"
                                            type="button"
                                            class="edit btn btn-warning btn-sm mx-3 my-2" >Edit</button>
                                    @endcan
                                    @can('delete', $comment)
                                        <form action="{{route('comments.destroy',$comment->id)}}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                delete
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        @empty
                        <span class="ml-4">No comments</span>
                        @endforelse
                    </div>
                </div>
                <div class="mt-2 p-2">
                    <form action="{{route('comments.store' , ['article' => $article->id])}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="content">Comment</label>
                            <textarea class="form-control" id="content" rows="3" name="content"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="editComment">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    @method('PATCH')
                    @csrf
                    <div class="form-group">
                        <label for="content">
                            Comment :
                        </label>
                        <input class="form-control" type="text" name="content">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.edit').click(function () {
              let modal = $('#editComment');
              let btn = $(this);
              modal.find('form').attr(
                'action',
                '/comments/'+btn.data('id')
              )
              modal.find('[name="content"]').val(btn.data('content'))
              modal.modal('show');
            });
        });
    </script>
@endsection
