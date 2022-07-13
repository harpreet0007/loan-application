<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * Validates data send true if no error else return json array for errors.
     *
     * @param array $data
     * @param array $rules
     * @return array|bool
     */

    protected function validateData($data = [], $rules = [])
    {
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }
        
        return true;
    }

    /**
     * API response format.
     *
     * @param string $message
     * @param array $data
     * @param int $code
     * @param int $result 0 for error, 1 for success
     * @return \Illuminate\Http\JsonResponse
     */

    protected function respondJson($message = '', $data = [], $code = 400, $result = 0)
    {
        return response()->json([
            'success' => $result,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
