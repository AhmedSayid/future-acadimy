<?php

namespace App\Traits;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

trait ResponseTrait
{
    public function successMsg($msg)
    {
        return response()->json(['key' => 'success', 'msg' => $msg]);
    }

    public function successData($data)
    {
        return response()->json(['key' => 'success', 'msg' => 'success','data' => $data]);
    }

    public function failMsg($msg)
    {
        return response()->json(['key' => 'fail', 'msg' => $msg]);
    }
}
