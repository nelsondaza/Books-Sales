<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
	use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

	/**
	 * GEneral Response Object
	 * @var array
	 */
	private $responseObject = [
		'data' => [],
		'error' => null
	];


	public function response($data, $HTTPCode = 200)
	{
		/**
		 * Data always an array
		 */
		if ($data && !is_array($data) && !($data instanceof \Traversable))
			$data = [$data];

		if ($data)
			$this->responseObject['data'] = $data;

		/**
		 * JSON
		 */
		return response()->json($this->responseObject, $HTTPCode);
	}

}
