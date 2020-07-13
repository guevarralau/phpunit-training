<?php

namespace Tests\Feature;

use App\Article;
use App\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteCommentTest extends TestCase
{
    public function setUp() : void
    {
        parent::setUp();
        $this->signIn();
    }
   /** @test */
   public function comment_author_can_delete_comment()
   {
//       $this->withoutExceptionHandling();
       $comment = create(Comment::class,[
           'user_id' => auth()->id()
       ]);
       $this->delete(route('comments.destroy',$comment->id))
           ->assertRedirect(route('articles.show',$comment->article->id));
       $this->assertDatabaseMissing('comments',[
           'id' => $comment->id,
           'content' => $comment->id,
           'user_id' => $comment->user_id,
           'article_id' => $comment->article_id,
       ]);
   }
}
