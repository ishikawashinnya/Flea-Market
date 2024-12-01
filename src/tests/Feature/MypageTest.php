<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Sold_item;
use App\Models\Like;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MypageTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex() {
        $response = $this->get('/mypage');
        $response->assertRedirect(route('login'));

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/mypage');
        $response->assertStatus(200);
        $response->assertViewIs('mypage');
        $response->assertViewHas(['user', 'items', 'soldItems', 'profile', 'profileImgUrl']);
    }

    public function testProfile() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/mypage/profile');

        $response->assertStatus(200);
        $response->assertViewIs('profile');
        $response->assertViewHas(['user', 'profile']);
    }

    public function test_profile_update() {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => 'New Name',
            'shipping_name' => 'New Shipping Name',
            'postcode' => '1234567',
            'address' => 'New Address',
            'building' => 'New Building'
        ];

        $response = $this->post(route('update.profile'), $data);
        $response->assertRedirect(route('profile'));
        $user = $user->fresh();

        $this->assertEquals('New Name', $user->name);
        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'shipping_name' => 'New Shipping Name',
            'postcode' => '1234567',
            'address' => 'New Address',
            'building' => 'New Building'
        ]);

        $response->assertSessionHas('success', 'プロフィールが更新されました');
    }
}