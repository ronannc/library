<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ResponseTrait;
    /**
     * @param \App\Http\Requests\UserRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store( UserRequest $request )
    {
        $data               = $request->all();
        $data[ 'password' ] = Hash::make( $data[ 'password' ] );
        $user               = User::create( $data );
    
        return $this->responseSuccess( $user->toArray(), 201 );
    }
    
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function auth( Request $request )
    {
        $user = User::where( 'email', $request->email )->first();
        if ( !$user || !Hash::check( $request->password, $user->password ) ) {
            return response( [
                                 'success' => false,
                                 'message' => 'Incorrect data!',
                                 'data'    => []
                             ], 400 );
        }
    
        return $this->responseSuccess( [ 'token' => $user->createToken( 'token_api' )->plainTextToken ] );
    }
}
