<?php

namespace User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class UserTest extends TestCase
{
    use DatabaseMigrations;
    
    protected $url;
    
    /**
     * @return \string[][][]
     */
    public function userProvider()
    {
        return [
            [
                [
                    "name"                  => "user 1",
                    "email"                 => "email@email.com",
                    "password"              => "teste1",
                    "password_confirmation" => "teste1",
                ],
                [
                    "name"                  => "user 2",
                    "email"                 => "email2@email.com",
                    "password"              => "teste2",
                    "password_confirmation" => "teste2",
                ]
            ]
        ];
    }
    
    /**
     * @dataProvider userProvider
     * @test
     */
    public function StoreSuccessUserTest( $data )
    {
        $response = $this->post( $this->url . "/api/users", $data );
        $response->assertStatus( 201 );
        $response->assertJson( [
                                   'success' => true,
                                   'message' => 'Request processed successfully!',
                                   'data'    => [
                                       "name"  => $data[ 'name' ],
                                       "email" => $data[ 'email' ],
                                   ]
                               ] );
        $this->assertDatabaseHas( 'users', [
            "name"  => $data[ 'name' ],
            "email" => $data[ 'email' ]
        ] );
    }
    
    /**
     * @return \string[][][]
     */
    public function UserFailProvider()
    {
        return [
            [
                [
                    "email"                 => "email@email.com",
                    "password"              => "teste1",
                    "password_confirmation" => "teste1",
                ],
                [
                    "name" => "user 2",
                    "password"              => "teste2",
                    "password_confirmation" => "teste2",
                ],
                [
                    "name"  => "user 2",
                    "email" => "email2@email.com",
                    "password_confirmation" => "teste2",
                ],
                [
                    "name"     => "user 2",
                    "email"    => "email2@email.com",
                    "password" => "teste2",
                ],
                [
                    "name"                  => "user 2",
                    "email"                 => "email2email.com",
                    "password"              => "teste2",
                    "password_confirmation" => "teste2",
                ],
                [
                    "name"                  => "user 2",
                    "email"                 => "email2@email.com",
                    "password"              => "teste",
                    "password_confirmation" => "teste2",
                ]
            ]
        ];
    }
    
    /**
     * @dataProvider userFailProvider
     * @test
     */
    public function StoreFailUserTest( $data )
    {
        $response = $this->post( $this->url . "/api/users", $data );
        $response->assertStatus( 400 );
        $response->assertJsonFragment( [
                                           'success' => false,
                                           'message' => "Validation errors",
                                       ] );
    }
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->url = env( 'APP_URL' );
    }
}
