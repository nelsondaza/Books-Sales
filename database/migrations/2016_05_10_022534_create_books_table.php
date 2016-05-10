<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('books', function (Blueprint $table) {
			$table->unsignedBigInteger('id', true);

			$table->string('author', 100)->index();
			$table->string('title', 250);
			$table->string('reference', 100)->index();
			$table->unsignedInteger('units_available')->default(0);
			$table->double('price')->unsigned()->default(0);
			$table->timestamp('published_at')->nullable();

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
		Schema::drop('books');
	}
}
