<?php

namespace App\Http\Controllers;

use App\Models\ErrorLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function log(\Exception $e)
    {
        $msg = 'Error in file: '.$e->getFile().' in line: '.$e->getLine().' the error is: '.$e->getMessage();
        ErrorLog::create(['message' => $msg]);
    }
}
