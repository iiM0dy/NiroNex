<?php
/*
 * Assist Traits
 */
namespace App\Traits;

trait ApiResponse
{
    static function assistApiResponse(mixed $data, ?string $message = null, int $status = 200)
    {
        $response = [];
        if ($status == 200) {
            $response = [
                'success' => true,
                'data' => $data,
                'message' => $message
            ];
        } else {
            $response = [
                'success' => false,
                'data' => null,
                'message' => $message
            ];
        }
        return response()->json($response, $status);
    }
}
