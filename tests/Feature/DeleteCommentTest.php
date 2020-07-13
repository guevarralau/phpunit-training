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
       $this->withoutExceptionHandling();
       $comment = new Comment;
       $comment->fill([
           'content' => 'sample comment',
           'user_id' => auth()->id(),
           'article_id' => create(Article::class,
           [
               'user_id' => auth()->id()
           ])->id
       ])->save();
//       dd($comment)
       $this->delete(route('comments.destroy',$comment->id))
           ->assertRedirect(route('articles.show',$comment->article->id));
       $this->assertDatabaseMissing('comments', $comment->toArray());
   }
}
