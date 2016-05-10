<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
	protected $fillable = ['author', 'title', 'reference', 'units_available', 'price', 'published_at'];
	protected $dates = ['published_at'];

	public function sales()
	{
		return $this->hasMany(Sales::class, 'book_id', 'id');
	}

}
