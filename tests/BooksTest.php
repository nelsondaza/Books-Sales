<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BooksTest extends TestCase
{
    /**
     * Test books list.
     *
     * @return void
     */
    public function testListBooks()
    {
        $this->get('/api/books')->seeJsonStructure([
            'error',
            'data' => []
        ])->seeJson([
            'error' => null,
        ]);
    }
}
