<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthorisedUserViewsTest extends TestCase
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
	
    public function testUserLogin()
    {
        $this->visit('/login')
             ->see('Inzaana | Log-In');
    }
 //    public function testNewUserRegistration()
    // {
    //     $this->visit('/register')
    //          ->type('Taylor', 'name')
    //          ->check('terms')
    //          ->press('Register')
    //          ->seePageIs('/dashboard');
    // }
}
