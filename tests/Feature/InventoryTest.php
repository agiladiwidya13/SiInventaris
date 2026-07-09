<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use App\Models\Borrowing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $staff;
    private User $manager;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);

        $this->admin = User::factory()->create(['role_id' => $adminRole->id]);
        $this->staff = User::factory()->create(['role_id' => $staffRole->id]);
        $this->manager = User::factory()->create(['role_id' => $managerRole->id]);

        $this->category = Category::create(['name' => 'Elektronik']);
    }

    public function test_admin_can_view_products()
    {
        $response = $this->actingAs($this->admin)->get(route('products.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_create_product()
    {
        $response = $this->actingAs($this->admin)->post(route('products.store'), [
            'code' => 'PRD-999',
            'name' => 'Test Product',
            'category_id' => $this->category->id,
            'stock' => 10,
            'location' => 'Gudang Test',
            'condition' => 'baik',
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', ['code' => 'PRD-999']);
    }

    public function test_staff_cannot_create_product()
    {
        $response = $this->actingAs($this->staff)->post(route('products.store'), [
            'code' => 'PRD-888',
            'name' => 'Unauthorized Product',
            'category_id' => $this->category->id,
            'stock' => 10,
            'location' => 'Gudang Test',
            'condition' => 'baik',
        ]);

        $response->assertStatus(403);
    }

    public function test_staff_can_record_borrowing_and_deducts_stock()
    {
        $product = Product::create([
            'code' => 'PRD-123',
            'name' => 'Borrowable Item',
            'category_id' => $this->category->id,
            'stock' => 5,
            'location' => 'Gudang A',
            'condition' => 'baik',
        ]);

        $response = $this->actingAs($this->staff)->post(route('borrowings.store'), [
            'user_id' => $this->staff->id,
            'borrow_date' => now()->format('Y-m-d'),
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                ]
            ]
        ]);

        $response->assertRedirect(route('borrowings.index'));
        $this->assertEquals(3, $product->fresh()->stock);
    }

    public function test_cannot_borrow_more_than_available_stock()
    {
        $product = Product::create([
            'code' => 'PRD-124',
            'name' => 'Low Stock Item',
            'category_id' => $this->category->id,
            'stock' => 1,
            'location' => 'Gudang A',
            'condition' => 'baik',
        ]);

        $response = $this->actingAs($this->staff)->from(route('borrowings.create'))->post(route('borrowings.store'), [
            'user_id' => $this->staff->id,
            'borrow_date' => now()->format('Y-m-d'),
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                ]
            ]
        ]);

        $response->assertRedirect(route('borrowings.create'));
        $this->assertEquals(1, $product->fresh()->stock);
    }
}
