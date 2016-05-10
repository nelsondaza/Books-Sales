<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BooksTest extends TestCase
{
	/**
	 * JSON object structure for book
	 * @var array
	 */
	private $structure = [
		'id',
		'author',
		'title',
		'reference',
		'units_available',
		'price',
		'published_at',
		'created_at',
		'updated_at',
	];

	/**
	 * Test books list.
	 *
	 * @return void
	 */
	public function testListBooks()
	{
		$this->get('/api/books')->seeJsonStructure([
			'error',
			'data' => [
				'*' => $this->structure
			]
		])->seeJson([
			'error' => null,
		]);
	}

	/**
	 * Test view one book
	 *
	 * @return void
	 */
	public function testViewBook()
	{

		$book = \App\Models\Books::orderByRaw("RAND()")->first();
		$this->get('/api/books/' . $book->id)->seeJsonStructure([
			'error',
			'data' => [
				$this->structure
			]
		])->seeJson([
			'error' => null,
			'id' => $book->id
		]);

		/**
		 * Test non existing book
		 */
		$this->get('/api/books/NaN')->seeJsonStructure([
			'error' => [
				'code',
				'message',
				'trace'
			],
			'data' => []
		])->seeJson([
			'code' => 404
		]);
	}

}
