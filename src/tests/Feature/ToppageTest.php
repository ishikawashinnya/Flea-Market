<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Sold_item;
use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ToppageTest extends TestCase
{
  use RefreshDatabase,WithFaker;
  /**
     * A basic feature test example.
     *
     * @return void
     */

  public function testIndex() {
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertViewIs('toppage');
    $response->assertViewHas('items');

    $user = User::factory()->create()->first();
    $this->actingAs($user);

    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertViewIs('toppage');
    $response->assertViewHas(['items', 'likes']);
  }
}
