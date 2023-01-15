<?php

namespace App\Trait;

trait ResponseTrait
{
    /**
     * @param $data
     * @param $code
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function responseSuccess( $data = [], $code = 200 )
    {
        return response( [
                             'success' => true,
                             'message' => 'Request processed successfully!',
                             'data'    => $data
                         ], $code );
    }
}
