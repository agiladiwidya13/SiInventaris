<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $role = Role::firstOrCreate(['name' => 'admin']);
        $this->user = User::factory()->create([
            'email' => 'api_test@telkomsel.id',
            'password' => 'password', 
            'role_id' => $role->id,
        ]);

        $category = Category::create(['name' => 'Elektronik']);
        Product::create([
            'code' => 'API-001',
            'name' => 'API Product',
            'category_id' => $category->id,
            'stock' => 5,
            'location' => 'Gudang Api',
            'condition' => 'baik',
        ]);
    }

    public function test_user_can_login_via_api_and_gets_token()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'api_test@telkomsel.id',
            'password' => 'password',
            'device_name' => 'test_device',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token', 'user']);
    }

    public function test_cannot_access_products_without_token()
    {
        $response = $this->getJson('/api/products');
        $response->assertStatus(401);
    }

    public function test_can_access_products_with_valid_token()
    {
        
        $loginResponse = $this->postJson('/api/login', [
            'email' => 'api_test@telkomsel.id',
            'password' => 'password',
            'device_name' => 'test_device',
        ]);
        
        $token = $loginResponse->json('token');

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->getJson('/api/products');

        $response->assertStatus(200)
                 ->assertJsonFragment(['code' => 'API-001']);
    }
}
