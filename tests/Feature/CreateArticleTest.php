<?php

namespace Tests\Feature;

use App\Article;
use Tests\TestCase;

class CreateArticleTest extends TestCase
{
    public function setUp() : void
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function a_user_can_go_to_create_form()
    {
        $this->get('/articles/create')
            ->assertSeeText('Create article');
    }

    /** @test */
    public function a_user_can_create_new_article()
    {
        $article = raw(Article::class);
        $this->post('/articles', $article)
             ->assertRedirect(route('articles.show',Article::first()->id ));

        $this->assertDatabaseHas('articles', [
            'title' => $article['title'],
            'content' => $article['content'],
            'tag' => $article['tag'],
            'user_id' => auth()->user()->id
        ]);
    }

    /** @test */
    public function all_fields_are_required()
    {
        $this->post('/articles', [])
            ->assertSessionHasErrors(['title', 'content', 'tag']);
    }
}
