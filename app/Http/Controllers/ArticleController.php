<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('author')->get();

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function show(Article $article)
    {
        $article->load('author');

        return view('articles.show', compact('article'));
    }

    public function store(ArticleRequest $request)
    {
        $article = Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'tag' => $request->tag,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('articles.show', $article);
    }

    public function edit(Article $article)
    {
        $this->authorize('update', $article);

        return view('articles.edit')->with('article',$article);
    }

    public function update(Article $article)
    {
        $this->authorize('update', $article);

        $article = tap($article)->update(request()->all());

        return redirect()->route('articles.show', $article);
    }
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $article->delete();
        return redirect()->route('articles.index');
    }
}
