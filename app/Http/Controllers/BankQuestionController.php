<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bank;
use App\Models\BankQuestion;
use App\Models\Chapter;
use Illuminate\Http\Request;

class BankQuestionController extends Controller
{
    public function index($id)
    {
        if (request()->ajax()){
            $rows = BankQuestion::where('subject_id',$id)->get();
            $html = view('platform.bankQuestions.table',compact('rows'))->render();
            return response()->json(['html' => $html, 'id' => $id]);
        }
        $chapters = Chapter::where('subject_id',$id)->get();
        return view('platform.bankQuestions.index', compact('id','chapters'));
    }

    public function store(Bank $request)
    {
        try {
            BankQuestion::create($request->validated());
            return response()->json(['key' => 'success', 'msg' => 'تم إضافة السؤال بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function getQuestionData($id)
    {
        try {
            $bank = BankQuestion::findOrFail($id);
            return response()->json(['key' => 'success', 'data' => $bank]);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function update(Bank $request, $id)
    {
        try {
            BankQuestion::findOrFail($id)->update($request->validated());
            return response()->json(['key' => 'success' , 'msg' => 'تم تعديل السؤال بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function delete($id)
    {
        try {
            BankQuestion::findOrFail($id)->delete();
            return response()->json(['key' => 'success' , 'msg' => 'تم حذف السؤال بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }
}
