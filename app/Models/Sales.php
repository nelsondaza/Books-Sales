<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
	protected $fillable = ['book_id', 'price'];

	public function book()
	{
		return $this->belongsTo(Books::class);
	}

}
