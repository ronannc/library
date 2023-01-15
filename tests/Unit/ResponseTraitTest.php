<?php

namespace Tests\Unit;

use Tests\TestCase;

class ResponseTraitTest extends TestCase
{
    use \App\Trait\ResponseTrait;
    
    /**
     * @return array[]
     */
    public function dataProvider()
    {
        return [
            [
                [
                    "name"  => "Livro teste",
                    "isbn"  => "1111111111111",
                    "value" => "9.39",
                ],
                201
            ],
            [
                [
                    "name"  => "Livro teste 2",
                    "isbn"  => "2222222222222",
                    "value" => "8.45",
                ],
                200
            ],
        ];
    }
    
    /**
     * @dataProvider dataProvider
     * @test
     */
    public function ResponseSuccessTest( $data, $code )
    {
        /** @var \Illuminate\Http\Response $response */
        $response = $this->responseSuccess( $data, $code );
        $this->assertEquals(
            $response,
            response( [
                          'success' => true,
                          'message' => 'Request processed successfully!',
                          'data'    => $data
                      ], $code )
        );
    }
    
    /**
     * @test
     */
    public function ResponseSuccessDefaultTest()
    {
        /** @var \Illuminate\Http\Response $response */
        $response = $this->responseSuccess();
        $this->assertEquals(
            $response,
            response( [
                          'success' => true,
                          'message' => 'Request processed successfully!',
                          'data'    => []
                      ] )
        );
    }
}
