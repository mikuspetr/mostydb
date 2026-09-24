<?php

namespace Tests\Feature;

use App\Models\Ebook;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontTest extends TestCase
{
    use RefreshDatabase;

    public function test_storefront_renders_active_ebooks(): void
    {
        Ebook::create([
            'title' => 'Laravel pro moderní web',
            'author' => 'Jan Novák',
            'description' => 'Popis ebooku',
            'price' => 299,
            'download_url' => 'https://example.com/laravel.pdf',
            'is_active' => true,
        ]);

        Ebook::create([
            'title' => 'Skrytá kniha',
            'author' => 'Autor',
            'description' => 'Neaktivní titul',
            'price' => 199,
            'download_url' => 'https://example.com/hidden.pdf',
            'is_active' => false,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Laravel pro moderní web');
        $response->assertDontSee('Skrytá kniha');
    }

    public function test_customer_can_create_order(): void
    {
        $ebook = Ebook::create([
            'title' => 'Vue.js v praxi',
            'author' => 'Petra Svobodová',
            'description' => 'Popis ebooku',
            'price' => 249,
            'download_url' => 'https://example.com/vue.pdf',
            'is_active' => true,
        ]);

        $response = $this->postJson('/orders', [
            'customer_name' => 'Petr Mikus',
            'customer_email' => 'petr@example.com',
            'items' => [
                [
                    'ebook_id' => $ebook->id,
                    'quantity' => 2,
                ],
            ],
        ]);

        $response->assertCreated()
            ->assertJsonPath('downloads.0.download_url', 'https://example.com/vue.pdf')
            ->assertJsonPath('total_price', '498.00');

        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Petr Mikus',
            'customer_email' => 'petr@example.com',
            'status' => 'paid',
        ]);

        $order = Order::query()->first();

        $this->assertNotNull($order);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'ebook_id' => $ebook->id,
            'quantity' => 2,
        ]);
    }
}
