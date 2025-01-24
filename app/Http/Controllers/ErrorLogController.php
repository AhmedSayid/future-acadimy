<?php

namespace App\Http\Controllers;

use App\Models\ErrorLog;
use Illuminate\Http\Request;

class ErrorLogController extends Controller
{
    public function index()
    {
        if (request()->ajax()){
            $rows = ErrorLog::latest()->get();
            $html = view('platform.errors.table',compact('rows'))->render();
            return response()->json(['html' => $html]);
        }
        return view('platform.errors.index');
    }

    public function getMessage($id)
    {
        $msg = ErrorLog::findOrFail($id);
        return response()->json(['key' => 'success', 'data' => $msg]);
    }
}
