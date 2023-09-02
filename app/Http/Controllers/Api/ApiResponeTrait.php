<?php 
namespace App\Http\Controllers\Api;
trait ApiResponseTrait
{
    public function apiResponse($data = null, $msg = null, $status = null)
    {
        $array = [
            'data' => $data,
            'msg' => $msg,
            'status' => $status
        ];

        return response($array, $status);
    }
}