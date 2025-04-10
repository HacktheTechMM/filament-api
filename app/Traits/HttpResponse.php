<?php

namespace App\Traits;

trait HttpResponse{

    public function success($message,$data=[],$status,$statusCode){

        return response()->json([
            'message'=>$message,
            'data'=>$data,
            'status'=>$status,
            'status_code'=>$statusCode
        ],$statusCode);
    }

    public function error($message,$data=[],$status=false,$statusCode=500){

        return response()->json([
            'message'=>$message,
            'data'=>$data,
            'status'=>$status,
            'status_code'=>$statusCode
        ],$statusCode);
    }
}
