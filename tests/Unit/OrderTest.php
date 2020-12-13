<?php

namespace Tests\Unit;

use Tests\TestCase;

/**
 * Class OrderTest
 * @package Tests\Unit
 */
class OrderTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     *
     */
    public function testCanOrder1()
    {
        $order = [
            1 => 1,
            2 => 2,
            3 => 1,
        ];

        $this->post(route('order'), $order)
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    /**
     *
     */
    public function testCanOrder2()
    {
        $order = [
            1 => 1,
            3 => 2
        ];

        $this->assertTrue(true);
        $this->post(route('order'), $order)
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    /**
     *
     */
    public function testCanOrder3()
    {
        $order = [
            5 => 4,
            3 => 1
        ];

        $this->assertTrue(true);
        $this->post(route('order'), $order)
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    /**
     *
     */
    public function testCanOrder4()
    {
        $order = [
            4 => 2
        ];

        $this->assertTrue(true);
        $this->post(route('order'), $order)
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

}
