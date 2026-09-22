<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TrackOrderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ],
        ]);

        DB::purge();
        DB::connection()->getSchemaBuilder()->create('customer', function ($table) {
            $table->increments('customerid');
            $table->string('customername')->nullable();
            $table->string('customermobile')->nullable();
            $table->string('customeremail')->nullable();
            $table->string('guid')->nullable();
            $table->tinyInteger('iStatus')->default(1);
            $table->tinyInteger('isDelete')->default(0);
            $table->timestamps();
        });

        DB::connection()->getSchemaBuilder()->create('order', function ($table) {
            $table->increments('order_id');
            $table->unsignedInteger('customerid')->nullable();
            $table->string('shipping_cutomerName')->nullable();
            $table->string('shipping_mobile')->nullable();
            $table->string('shipping_email')->nullable();
            $table->text('shiiping_address1')->nullable();
            $table->text('shiiping_address2')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shiiping_state')->nullable();
            $table->string('shipping_pincode')->nullable();
            $table->string('country')->nullable();
            $table->decimal('netAmount', 10, 2)->default(0);
            $table->tinyInteger('iStatus')->default(1);
            $table->tinyInteger('isDelete')->default(0);
            $table->timestamps();
        });

        DB::connection()->getSchemaBuilder()->create('product', function ($table) {
            $table->increments('productId');
            $table->string('productname');
            $table->tinyInteger('iStatus')->default(1);
            $table->tinyInteger('isDelete')->default(0);
            $table->timestamps();
        });

        DB::connection()->getSchemaBuilder()->create('orderdetail', function ($table) {
            $table->increments('orderDetailId');
            $table->unsignedInteger('orderID');
            $table->unsignedInteger('customerid');
            $table->unsignedInteger('productId');
            $table->integer('quantity')->default(1);
            $table->decimal('rate', 10, 2)->default(0);
            $table->decimal('amount', 10, 2)->default(0);
            $table->unsignedInteger('size')->nullable();
            $table->tinyInteger('iStatus')->default(1);
            $table->tinyInteger('isDelete')->default(0);
            $table->timestamps();
        });

        DB::connection()->getSchemaBuilder()->create('productphotos', function ($table) {
            $table->increments('id');
            $table->unsignedInteger('productid');
            $table->string('strphoto')->nullable();
        });

        DB::connection()->getSchemaBuilder()->create('product_attributes', function ($table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->string('product_attribute_size')->nullable();
        });
    }

    public function test_track_order_page_shows_orders_for_registered_mobile_number(): void
    {
        $this->withoutExceptionHandling();

        $customerId = DB::table('customer')->insertGetId([
            'customername' => 'Test User',
            'customermobile' => '9999999999',
            'customeremail' => 'test@example.com',
            'guid' => 'abc123',
            'iStatus' => 1,
            'isDelete' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $order = Order::create([
            'customerid' => $customerId,
            'shipping_cutomerName' => 'Test User',
            'shipping_mobile' => '9999999999',
            'shipping_email' => 'test@example.com',
            'shiiping_address1' => 'Main Street',
            'shiiping_address2' => 'Near City',
            'shipping_city' => 'Pune',
            'shiiping_state' => 'MH',
            'shipping_pincode' => '411001',
            'country' => 'India',
            'netAmount' => 499,
            'iStatus' => 1,
            'isDelete' => 0,
        ]);

        $product = DB::table('product')->insertGetId([
            'productname' => 'Cotton T-Shirt',
            'iStatus' => 1,
            'isDelete' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('productphotos')->insert([
            'productid' => $product,
            'strphoto' => 'shirt.jpg',
        ]);

        DB::table('product_attributes')->insert([
            'product_id' => $product,
            'product_attribute_size' => 'M',
        ]);

        DB::table('orderdetail')->insert([
            'orderID' => $order->order_id,
            'customerid' => $customerId,
            'productId' => $product,
            'quantity' => 2,
            'rate' => 250,
            'amount' => 500,
            'size' => 1,
            'iStatus' => 1,
            'isDelete' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->get('/track-order?phone=9999999999');

        $response->assertStatus(200);
        $response->assertSee('Cotton T-Shirt');
        $response->assertSee('Order');
    }
}
