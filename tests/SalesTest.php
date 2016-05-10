<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SalesTest extends TestCase
{
	private $structure = [
		'id',
		'book_id',
		'price',
		'created_at',
		'updated_at',
	];

	/**
	 * Test sales list.
	 *
	 * @return void
	 */
	public function testListSales()
	{
		$this->get('/api/sales')->seeJsonStructure([
			'error',
			'data' => [
				'*' => $this->structure
			]
		])->seeJson([
			'error' => null,
		]);
	}

	/**
	 * Test view one sale
	 *
	 * @return void
	 */
	public function testViewSale()
	{

		$sale = \App\Models\Sales::orderByRaw("RAND()")->first();
		$this->get('/api/sales/' . $sale->id)->seeJsonStructure([
			'error',
			'data' => [
				$this->structure
			]
		])->seeJson([
			'error' => null,
			'id' => $sale->id
		]);

		/**
		 * Test non existing sale
		 */
		$this->get('/api/sales/NaN')->seeJsonStructure([
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
	 * Test create/delete a sale
	 *
	 * @return void
	 */
	public function testCreateSale()
	{
		$sale = factory(\App\Models\Sales::class, 1)->make();

		$result = $this->post('/api/sales/', $sale->getAttributes())->seeJsonStructure([
			'error',
			'data' => [
				$this->structure
			]
		])->seeJson([
			'error' => null,
		])->decodeResponseJson();
		$resultData = $result['data'][0];

		/**
		 * Remove the newly created sale just to keep it clean
		 */
		$this->delete('/api/sales/' . $resultData['id'])->seeJsonStructure([
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
		$sale = new \App\Models\Sales();
		$this->post('/api/sales/', $sale->getAttributes())->seeJsonStructure([
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

	/**
	 * Test edit/update a sale
	 *
	 * @return void
	 */
	public function testEditSale()
	{
		$sale = factory(\App\Models\Sales::class, 1)->make();

		/**
		 * The book to sale
		 */
		$book = $this->get('/api/books/' . $sale->book_id )->seeJsonStructure([
			'error',
			'data' => []
		])->seeJson([
			'error' => null,
			'id' => $sale->book_id
		])->decodeResponseJson();

		/**
		 * Sold!
		 */
		$result = $this->post('/api/sales/', $sale->getAttributes())->seeJsonStructure([
			'error',
			'data' => [
				$this->structure
			]
		])->seeJson([
			'error' => null,
		])->decodeResponseJson();
		$resultData = $result['data'][0];

		/**
		 * The book has less available units, right?
		 */
		$bookUsed = $this->get('/api/books/' . $sale->book_id )->seeJsonStructure([
			'error',
			'data' => []
		])->seeJson([
			'error' => null,
			'id' => $sale->book_id
		])->decodeResponseJson();

		/**
		 * Units available changed
		 */
		$this->assertEquals( $book['data'][0]['units_available'] - 1, $bookUsed['data'][0]['units_available'] );


		/**
		 * Update the newly created sale
		 */
		$sale->price = 9999999;
		$this->put('/api/sales/' . $resultData['id'], $sale->getAttributes())->seeJsonStructure([
			'error',
			'data' => [
				$this->structure
			]
		])->seeJson([
			'error' => null,
			'price' => $sale->price
		]);

		/**
		 * Update the newly created sale with a wrong book
		 *
		 */
		$this->put('/api/sales/' . $resultData['id'], ['book_id' => 999999])->seeJsonStructure([
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

		/**
		 * Remove the newly created sale just to keep it clean
		 */
		$resultData = $result['data'][0];
		$this->delete('/api/sales/' . $resultData['id'])->seeJsonStructure([
			'error',
			'data' => [
				$this->structure
			]
		])->seeJson([
			'error' => null,
			'id' => $resultData['id']
		]);

		/**
		 * The book has the original available units, right?
		 */
		$bookUsed = $this->get('/api/books/' . $sale->book_id )->seeJsonStructure([
			'error',
			'data' => []
		])->seeJson([
			'error' => null,
			'id' => $sale->book_id
		])->decodeResponseJson();

		/**
		 * Units available changed back
		 */
		$this->assertEquals( $book['data'][0]['units_available'], $bookUsed['data'][0]['units_available'] );
	}
}
