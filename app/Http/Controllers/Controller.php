<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Validation\ValidationException;

class Controller extends BaseController
{
	use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

	/**
	 * General Response Object
	 * @var array
	 */
	private $responseObject = [
		'data' => [],
		'error' => null
	];

	/**
	 * General JSON response
	 * @param $data
	 * @param int $HTTPCode
	 * @return \Illuminate\Http\JsonResponse
	 */
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

	/**
	 * Error JSON response
	 * @param $message
	 * @param $code
	 * @param int $HTTPCode
	 * @param null $data
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function responseFail( $message, $code, $HTTPCode = 404, $data = null ) {

		/**
		 * Error need: user message, error code, trace for debug
		 */
		$this->responseObject['error'] = [
			'message' => $message,
			'code' => $code,
			'trace' => null
		];
		return $this->response( $data, $HTTPCode );
	}

	/**
	 * Response for validation errors
	 * @param Request $request
	 * @param array $errors
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function buildFailedValidationResponse( Request $request, array $errors ) {
		return $this->responseFail( 'Validation Error.', 422, 422, $errors );
	}

	/**
	 * Response with a JSON version of the Exception
	 * @param \Exception $exception
	 * @param int $HTTPCode
	 * @param null $data
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function responseException( \Exception $exception, $HTTPCode = 404, $data = null ) {

		if( $exception instanceof ValidationException ) {
			$this->responseObject['error'] = $exception->getResponse()->getData(true)['error'];
			$data = $exception->getResponse()->getData(true)['data'];
		}
		else {
			$this->responseObject['error'] = [
				'message' => $exception->getMessage(),
				'code' => $exception->getCode() || $HTTPCode,
			];
		}

		/**
		 * Just for debug to give more details
		 */
		if( env('APP_DEBUG')) {
			$this->responseObject['error']['trace'] = array_slice( $exception->getTrace(), 0, 5 );
		}

		return $this->response( $data, $HTTPCode );
	}


}
