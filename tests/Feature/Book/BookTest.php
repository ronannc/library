<?php

namespace Book;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class BookTest extends TestCase
{
    use DatabaseMigrations;
    
    protected $url;
    
    /**
     * @test
     */
    public function ListBookTest()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        Book::factory()->count( 10 )->create();
        $response = $this->get( $this->url . "/api/books" );
        $response->assertOk();
        $response->assertJsonStructure( [
                                            'current_page',
                                            'data' => [
                                                [
                                                    'id',
                                                    'name',
                                                    'isbn',
                                                    'value'
                                                ]
                                            ],
                                            'first_page_url',
                                            'from',
                                            'next_page_url',
                                            'path',
                                            'per_page',
                                            'prev_page_url',
                                            'to'
                                        ] );
    }
    
    /**
     * @return \array[][]
     */
    public function bookProvider()
    {
        return [
            [
                [
                    "name"  => "Livro teste",
                    "isbn"  => "1111111111111",
                    "value" => "9.39",
                ],
                [
                    "name"  => "Livro teste 2",
                    "isbn"  => "1236549874561",
                    "value" => "7.50",
                ]
            ]
        ];
    }
    
    /**
     * @dataProvider bookProvider
     * @test
     */
    public function StoreSuccessBookTest( $data )
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->post( $this->url . "/api/books", $data );
        $response->assertStatus( 201 );
        $response->assertJson( [
                                   'success' => true,
                                   'message' => 'Request processed successfully!',
                                   'data'    => [
                                       "name"  => $data[ 'name' ],
                                       "isbn"  => $data[ 'isbn' ],
                                       "value" => $data[ 'value' ],
                                   ]
                               ] );
        $this->assertDatabaseHas( 'books', [
            "name"  => $data[ 'name' ],
            "isbn"  => $data[ 'isbn' ],
            "value" => $data[ 'value' ],
        ] );
    }
    
    /**
     * @return \array[][]
     */
    public function bookFailProvider()
    {
        return [
            [
                [
                    "isbn"  => "1111111111111",
                    "value" => "9.39",
                ],
                [
                    "name"  => "Livro teste 2",
                    "value" => "7.50",
                ],
                [
                    "name" => "Livro teste 2",
                    "isbn" => "1236549874561",
                ],
                [
                    "name"  => "Livro teste 2",
                    "isbn"  => "1236549874561645654",
                    "value" => "7.50",
                ],
                [
                    "name"  => "Livro teste 2",
                    "isbn"  => "1236549874561",
                    "value" => "7.50987",
                ]
            ]
        ];
    }
    
    /**
     * @dataProvider bookFailProvider
     * @test
     */
    public function StoreFailBookTest( $data )
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->post( $this->url . "/api/books", $data );
        $response->assertStatus( 400 );
        $response->assertJsonFragment( [
                                           'success' => false,
                                           'message' => "Validation errors",
                                       ] );
    }
    
    /**
     * @dataProvider bookProvider
     * @test
     */
    public function UpdateBookTest( $data )
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $book     = Book::factory()->create();
        $response = $this->put( $this->url . "/api/books/$book->id", $data );
        $response->assertOk();
        $data[ 'id' ] = $book->id;
        $response->assertJson( [
                                   'success' => true,
                                   'message' => "Request processed successfully!",
                                   'data'    => $data
                               ] );
    }
    
    /**
     * @test
     */
    public function DeleteBookTest()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $book     = Book::factory()->create();
        $response = $this->delete( $this->url . "/api/books/$book->id" );
        $response->assertOk();
        $response->assertJson( [
                                   'success' => true,
                                   'message' => "Request processed successfully!",
                                   'data'    => []
                               ] );
    }
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->url = env( 'APP_URL' );
    }
}
