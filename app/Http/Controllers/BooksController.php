<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;

use App\Http\Requests;

class BooksController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return $this->response( Books::all() );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->validateRequest($request);
		$book = Books::create( $request->all() );

		/**
		 * Response with the new object
		 */
		return $this->response( $book );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$book = Books::find( $id );
		if( $book ) {
			/**
			 * List sales too
			 */
			$book->sales;
			return $this->response($book);
		}
		return $this->responseFail( 'Book not found.', 404 );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$book = Books::find( $id );

		if( $book ) {
			$this->validateUpdateRequest($request);

			/**
			 * Not required for update
			 */
			$book->author = $request->get('author', $book->author);
			$book->title = $request->get('title', $book->title);
			$book->reference = $request->get('reference', $book->reference);
			$book->units_available = $request->get('units_available', $book->units_available);
			$book->price = $request->get('price', $book->price);
			$book->published_at = $request->get('published_at', $book->published_at);

			$book->save();
			return $this->response($book);

		}

		return $this->responseFail("Book not found.", 404);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$book = Books::find( $id );

		if( $book ) {
			if( $book->delete() )
				return $this->response($book);
			return $this->responseFail("Action not allowed.", 403);
		}

		return $this->responseFail("Book not found.", 404);
	}

	/**
	 * Validate form data
	 * @param Request $request
	 */
	private function validateRequest( Request $request ) {
		$this->validate($request, [
			'author' => 'required|min:2',
			'title' => 'required|min:2',
			'reference' => 'required',
			'units_available' => 'required|numeric|min:0',
			'price' => 'required|numeric|min:1',
			'published_at' => 'required|date',
		],[
			'required' => 'The :attribute field is required.',
			'min' => 'The :attribute field needs at least :min chars.',
			'numeric' => 'The :attribute field needs to be numeric.',
			'date' => 'The :attribute field needs to a valid date.',
			'price.min' => 'The :attribute needs to be equals or bigger than 1.',
		]);
	}

	/**
	 * Validate form data for update
	 * @param Request $request
	 */
	private function validateUpdateRequest( Request $request ) {
		$this->validate($request, [
			'author' => 'min:2',
			'title' => 'min:2',
			'units_available' => 'numeric|min:0',
			'price' => 'numeric|min:1',
			'published_at' => 'date',
		],[
			'min' => 'The :attribute field needs at least :min chars.',
			'numeric' => 'The :attribute field needs to be numeric.',
			'date' => 'The :attribute field needs to a valid date.',
			'price.min' => 'The :attribute needs to be equals or bigger than 1.',
		]);
	}
}
