<?php

namespace Tests\Feature;

use App\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FetchArticlesTest extends TestCase
{
    public function setUp() : void
    {
        parent::setUp();
        $this->signIn();
    }

    /** @test */
    public function it_should_have_a_list_of_articles()
    {
        $articles = create(Article::class, [
            'user_id' => auth()->user()->id
        ], 10);

        $response = $this->get('/articles');

        $response->assertSee($articles->first()->title);
        $response->assertSee($articles->first()->content);
        $response->assertSee($articles->first()->tag);
        $response->assertSee($articles->first()->author->name);

        $response->assertSeeText('Post new article');
    }

    /** @test */
    public function a_user_can_see_the_article_single_page()
    {
        $article = create(Article::class, [
            'user_id' => auth()->user()->id
        ]);

        $this->get("/articles/{$article->id}")
            ->assertSeeText($article->title)
            ->assertSeeText($article->content)
            ->assertSeeText($article->tag);
    }
}
