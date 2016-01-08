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
	
    public function testNewUserRegistration()
    {
        $this->visit('/sign-up')
             ->see('Inzaana | Sign-Up');
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
