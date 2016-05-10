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

	/**
	 * Test create/delete a book
	 *
	 * @return void
	 */
	public function testCreateBook()
	{
		$book = factory(\App\Models\Books::class, 1)->make();

		$result = $this->post('/api/books/', $book->getAttributes())->seeJsonStructure([
			'error',
			'data' => [
				$this->structure
			]
		])->seeJson([
			'error' => null,
		])->decodeResponseJson();
		$resultData = $result['data'][0];

		/**
		 * Remove the newly created book just to keep it clean
		 */
		$this->delete('/api/books/' . $resultData['id'])->seeJsonStructure([
			'error',
			'data' => [
				$this->structure
			]
		])->seeJson([
			'error' => null,
			'id' => $resultData['id']
		]);


		/**
		 * Test general validations error
		 */
		$book = new \App\Models\Books();
		$this->post('/api/books/', $book->getAttributes())->seeJsonStructure([
			'error' => [
				'code',
				'message',
				'trace'
			],
			'data' => []
		])->seeJson([
			'message' => "Validation Error.",
			'code' => 422
		]);
	}

}
