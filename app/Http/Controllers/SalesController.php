<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Sales;
use Illuminate\Http\Request;

use App\Http\Requests;

class SalesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return $this->response(Sales::all());
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

		/**
		 * available book?.
		 */
		$book = Books::find($request->get('book_id'));
		if ($book->units_available <= 0)
			return $this->responseFail('Validation Error.', 422, 422, ['book_id' => 'No units available of this book.']);

		$sale = Sales::create($request->all());
		$book->units_available--;
		$book->save();

		return $this->response($sale);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$sale = Sales::find($id);
		if ($sale)
			return $this->response($sale);
		return $this->responseFail('Sale not found.', 404);

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
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$sale = Sales::find($id);

		if ($sale) {
			if ($sale->delete()) {

				/**
				 * Now we have one available book, right?.
				 */
				$book = $sale->book;
				$book->units_available++;
				$book->save();

				return $this->response($sale);
			}
			return $this->responseFail("Action not allowed.", 403);
		}

		return $this->responseFail("Sale not found.", 404);
	}

	/**
	 * Validate form data
	 * @param Request $request
	 */
	private function validateRequest(Request $request)
	{
		$this->validate($request, [
			'book_id' => 'required|exists:books,id',
			'price' => 'required|numeric|min:1',
		], [
			'required' => 'The :attribute field is required.',
			'books_id.exists' => 'Not an existing book for this sale.',
			'min' => 'The :attribute field needs at least :min chars.',
			'numeric' => 'The :attribute field needs to be numeric.',
			'price.min' => 'The :attribute needs to be equals or bigger than 1.',
		]);
	}

}
