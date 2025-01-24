<?php

namespace App\Http\Controllers;

use App\Models\BankQuestion;
use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function index($id)
    {
        if(request()->ajax()){
            $rows = Chapter::where('subject_id' , $id)->paginate(10);
            $html = view('platform.chapters.table', compact('rows'))->render();
            return response()->json(['html' => $html]);
        }
        return view('platform.chapters.index',compact('id'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate(['name' => 'required', 'subject_id' => 'required|exists:subjects,id']);
            Chapter::create([
                'name'          => $request->name,
                'subject_id'    => $request->subject_id,
            ]);
            return response()->json(['key' => 'success' , 'msg' => 'تم إضافة الصف بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function getChapterData($id)
    {
        try {
            $data = Chapter::findOrFail($id);
            return response()->json(['key' => 'success', 'data' => $data]);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate(['name' => 'required']);
            Chapter::findOrFail($id)->update(['name' => $request->name]);
            return response()->json(['key' => 'success' , 'msg' => 'تم تعديل الصف بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function delete($id)
    {
        try {
            Chapter::findOrFail($id)->delete();
            return response()->json(['key' => 'success' , 'msg' => 'تم مسح الصف بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }
}
