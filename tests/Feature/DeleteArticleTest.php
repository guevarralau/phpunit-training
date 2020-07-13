<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DeleteArticleTest extends TestCase
{
  public function setUp(): void
  {
      parent::setUp();
      $this->signIn();
  }
  /** @test */
  public function a_user_can_only_delete_his_articles()
  {
      $user = create(User::class);
      $article = create(Article::class,[
          'user_id' => $user->id
      ]);
      $this->delete(route('articles.destroy',[$article]))
      ->assertForbidden();
  }
  /** @test */
  public function a_user_can_delete_his_articles()
  {
      $article = create(Article::class,[
          'user_id' => auth()->id()
      ]);
      $this->delete(route('articles.destroy', [$article]))
          ->assertStatus(Response::HTTP_FOUND);
      $this->assertDatabaseMissing('articles', $article->toArray());
  }
}
