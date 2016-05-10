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
        $this->get('/api/sales/' . $sale->id )->seeJsonStructure([
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
        $this->get('/api/sales/NaN' )->seeJsonStructure([
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
