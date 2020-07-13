<?php

namespace Tests\Feature;
use App\Article;
use App\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCommentTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->signIn();
    }

    /** @test */
    public function a_user_can_add_comment_to_article()
    {
        $article = create(Article::class,[
            'user_id' => auth()->id(),
        ]);

        $comment = raw(Comment::class,[
            'content' => 'this post sucks',
        ]);
        $this->post(route('comments.store',
            [
                'article' => $article->id
            ]),$comment)
            ->assertRedirect(route('articles.show',['article' => $article->id]));
        $this->assertDatabaseHas('comments', $comment);
    }

    /** @test */
    public function content_field_is_required()
    {
        $this->post(
            route('comments.store', [
                    'article' => create(Article::class,
                        [
                            'user_id' => auth()->id()
                        ]
                    )->id
                ]), [])
            ->assertSessionHasErrors('content');
    }
}
