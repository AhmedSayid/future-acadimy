<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Traits\GetId;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    use GetId;
    public function index()
    {
        if(request()->ajax()){
            $rows = Grade::where('teacher_id' , $this->getTeacherId())->paginate(10);
            $html = view('platform.grades.table', compact('rows'))->render();
            return response()->json(['html' => $html]);
        }
        return view('platform.grades.index');
    }

    public function store(Request $request)
    {
        try {
            $request->validate(['name' => 'required']);
            Grade::create([
                'name'          => $request->name,
                'teacher_id'    => $this->getTeacherId(),
                'test_error'    => 'ssss',
            ]);
            return response()->json(['key' => 'success' , 'msg' => 'تم إضافة الصف بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function getGradeData($id)
    {
        try {
            $data = Grade::findOrFail($id);
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
            Grade::findOrFail($id)->update(['name' => $request->name]);
            return response()->json(['key' => 'success' , 'msg' => 'تم تعديل الصف بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function delete($id)
    {
        try {
            Grade::findOrFail($id)->delete();
            return response()->json(['key' => 'success' , 'msg' => 'تم مسح الصف بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }
}
