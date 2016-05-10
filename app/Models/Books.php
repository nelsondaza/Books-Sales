<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
	protected $fillable = [
		'author',
		'title',
		'reference', // Don't really know about this field :/
		'units_available',  // 0 or bigger
		'price', // COP
		'published_at' // Just the year?
	];
	protected $dates = ['published_at'];

	/**
	 * List all book's sales
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function sales()
	{
		return $this->hasMany(Sales::class, 'book_id', 'id');
	}

}
