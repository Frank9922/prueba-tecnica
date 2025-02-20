<?php 


namespace App\Http\Services;


class ApiResponse {

    public static function succes(array $data, $status = 200)
    {
        return response()->json($data, $status);
    }

    public static function error(array $data, $status = 400)
    {
        return response()->json($data, $status);
    }
}


?>