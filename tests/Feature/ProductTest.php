<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    private $customer = array(
        'username' => 'customer',
        'password' => 'cust234'
    );

    private $merchant = array(
        'username' => 'anwari',
        'password' => 'cust123'
    );


    /** @test */
    public function getListProductTest()
    {

        //without login
        $response = $this->getJson('/api/v1/product');

        $response->assertStatus(401);

        //with login
        $this->json('POST', '/api/v1/login', $this->customer);

        $response = $this->getJson('/api/v1/product');

        $response->assertStatus(200);
    }

    /** @test */
    public function postProductTest()
    {
        $product = array(
            'name' => 'power bank',
            "price" => 9,
            "stock" => 2000
        );

        //without login
        $response = $this->postJson('/api/v1/product', $product);

        $response->assertStatus(401);

        //with customer login
        $this->json('POST', '/api/v1/login', $this->customer);

        $response = $this->postJson('/api/v1/product', $product);

        $response->assertStatus(403);

        //with merchant login
        $this->json('POST', '/api/v1/login', $this->merchant);

        $response = $this->postJson('/api/v1/product', $product);

        $response->assertStatus(200);

        $product['merchant'] = $this->merchant['username'];
        $response->assertJson(array(
            'added' => $product
        ));
    }
}
