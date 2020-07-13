<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Article;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\CommentUpdateRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param CommentStoreRequest $request
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CommentStoreRequest $request, Article $article)
    {
        $comment = Comment::create([
           'content' => $request->content,
           'user_id' => auth()->id(),
           'article_id' => $article->id,
        ]);
        return redirect()->route('articles.show', ['article' => $article->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * @param CommentUpdateRequest $request
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(CommentUpdateRequest $request, Comment $comment)
    {
        $this->authorize('update', $comment);
        $comment->update($request->all());
        return redirect()->back();
    }

    /**
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return redirect()->route('articles.show',$comment->article->id);
    }
}
