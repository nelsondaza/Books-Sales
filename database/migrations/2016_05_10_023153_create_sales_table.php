<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sales', function (Blueprint $table) {
			$table->unsignedBigInteger('id', true);

			/**
			 * Books relation
			 */
			$table->unsignedBigInteger('book_id');
			$table->foreign('book_id')->references('id')->on('books');

			$table->double('price')->unsigned()->default(0);

			$table->softDeletes(); // Don't know if I'll use it, but...
			$table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sales');
	}
}
