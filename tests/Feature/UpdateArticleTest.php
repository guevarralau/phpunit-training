<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdateArticleTest extends TestCase
{
    public function setUp() : void
    {
        parent::setUp();

        $this->signIn();
    }
    /** @test **/
    public function a_user_can_only_view_edit_article_page()
    {
        $user = create(User::class);
        $article = create(Article::class,[
            'user_id' => $user->id
        ]);
        $this->get(route('articles.edit', $article))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function a_user_can_update_an_article()
    {
        $this->withoutExceptionHandling();
        $article = create(Article::class, [
            'user_id' => auth()->user()->id
        ]);

        $updated = [
            'title' => 'Changed title',
            'content' => 'Changed content.',
            'tag' => 'tag',
        ];

        $this->patch("/articles/{$article->id}", $updated);

        tap($article->fresh(), function ($article) {
            $this->assertEquals('Changed title', $article->title);
            $this->assertEquals('Changed content.', $article->content);
        });
    }

    /** @test */
    public function author_can_only_update_his_articles()
    {
        $user = create(User::class);

        $article = create(Article::class, [
            'user_id' => $user->id
        ]);

        $updated = [
            'title' => 'Changed title',
            'content' => 'Changed content.',
        ];

        $this->patch("/articles/{$article->id}", $updated)
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /** @test */
    public function author_can_only_view_his_articles()
    {
//        $this->withoutExceptionHandling();
        $user = create(User::class);

        $article = create(Article::class, [
            'user_id' => $user->id
        ]);
        $this->get(route('articles.edit', $article->id))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
