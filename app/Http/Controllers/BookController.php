<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Trait\ResponseTrait;

class BookController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response( Book::simplePaginate() );
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreBookRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store( StoreBookRequest $request )
    {
        $book = Book::create( $request->all() );
    
        return $this->responseSuccess( $book->toArray(), 201 );
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateBookRequest $request
     * @param \App\Models\Book                     $book
     *
     * @return \Illuminate\Http\Response
     */
    public function update( UpdateBookRequest $request, Book $book )
    {
        $book->update( $request->all() );
    
        return $this->responseSuccess( $book->toArray() );
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Book $book
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy( Book $book )
    {
        $book->delete();
    
        return $this->responseSuccess();
    }
}
