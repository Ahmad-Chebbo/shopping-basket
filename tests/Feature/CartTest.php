<?php

namespace Tests\Feature;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_can_add_item_to_basket()
    {
        $this->withoutMiddleware();

        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)
            ->withSession([])
            ->post('/api/cart/add', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('baskets', [
            'user_id' => $user->id,
        ]);
        $this->assertDatabaseHas('basket_items', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        $this->assertTrue(true);
    }

    public function test_user_can_get_items_from_basket()
    {
        $user = User::latest()->first();
        $response = $this->actingAs($user)->get('/api/cart');
        $response->assertStatus(200);
    }

    public function test_user_can_remove_item_from_basket()
    {
        $user = User::factory()->create();
        $basket = Basket::create(['user_id' => $user->id]);
        $product = Product::factory()->create();
        $item = BasketItem::create([
            'basket_id' => $basket->id,
            'product_id' => $product->id,
            'price' => $product->price,
            'quantity' => 1,
            'removed' => false,
            'total' => $product->price,
        ]);

        $response = $this->actingAs($user)
                ->withSession([])
                ->post('/api/cart/remove', [
                'product_id' => $item->id,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('basket_items', [
            'id' => $item->id,
            'removed' => false,
        ]);
    }


    // public function test_admin_can_access_admin_dashboard()
    // {
    //     $admin = User::factory()->create(['role' => 'admin']);

    //     $response = $this->actingAs($admin)->get('/admin/dashboard');

    //     $response->assertStatus(200);
    // }

    // public function test_sales_team_can_access_admin_dashboard()
    // {
    //     $salesTeam = User::factory()->create(['role' => 'sales_team']);

    //     $response = $this->actingAs($salesTeam)->get('/admin/dashboard');

    //     $response->assertStatus(200);
    // }

}
