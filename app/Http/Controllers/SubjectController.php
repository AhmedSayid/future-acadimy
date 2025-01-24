<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use App\Traits\GetId;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubjectController extends Controller
{
    use GetId;
    public function index(): JsonResponse | View
    {
        if(request()->ajax()){
            $rows = Subject::where('teacher_id' , $this->getTeacherId())->paginate(10);
            $html = view('platform.subjects.table', compact('rows'))->render();
            return response()->json(['html' => $html]);
        }
        $grades = Grade::where('teacher_id' , $this->getTeacherId())->get();
        return view('platform.subjects.index', compact('grades'));
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate(['name' => 'required' , 'grade_id' => 'required|exists:grades,id']);
            Subject::create([
                'name'          => $request->name,
                'grade_id'      => $request->grade_id,
                'teacher_id'    => $this->getTeacherId(),
            ]);
            return response()->json(['key' => 'success' , 'msg' => 'تم إضافة المادة بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function getSubjectData($id): JsonResponse
    {
        try {
            $data = Subject::findOrFail($id);
            return response()->json(['key' => 'success', 'data' => $data]);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $request->validate(['name' => 'required' , 'grade_id' => 'required|exists:grades,id']);
            Subject::findOrFail($id)->update(['name' => $request->name, 'grade_id' => $request->grade_id]);
            return response()->json(['key' => 'success' , 'msg' => 'تم تعديل المادة بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            Subject::findOrFail($id)->delete();
            return response()->json(['key' => 'success' , 'msg' => 'تم مسح المادة بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }
}
