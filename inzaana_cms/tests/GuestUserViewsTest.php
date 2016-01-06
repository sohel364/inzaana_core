<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GuestUserViewsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    // public function testAboutUsLink()
    // {
    //     $this->visit('/')
    //          ->click('About us')
    //          ->seePageIs('/about-us');
    // }

    public function testHomeTitle()
    {
        $this->visit('/')
             ->see('Inzaana | Home');
    }

    public function testHomePageRouting()
	{
	    $response = $this->call('GET', '/');
	    $this->assertEquals(200, $response->status());
	}
}
