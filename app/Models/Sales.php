<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
	protected $fillable = [
		'book_id', // Book that was sold
		'price', // Price at the time it was sold
	];

	/**
	 * The book that was sold
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function book()
	{
		return $this->belongsTo(Books::class);
	}

}
