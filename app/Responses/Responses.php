<?php
namespace App\Responses;
trait Responses{

    public function sendSuccessResponse($message)
    {
        return response()->json([
            'success' => true,
            'message' =>  $message
        ], 200);
    }

    public function sendFailureResponse($message)
    {
        return response()->json([
            'success' => false,
            'message' => ['msg' => $message]
        ], 404);
    }
}