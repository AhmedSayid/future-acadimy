<?php

namespace App\Http\Controllers;

use App\Enums\RoleType;
use App\Http\Requests\Teacher;
use App\Http\Requests\TeacherUpdate;
use App\Models\SubjectStudent;
use App\Models\User;
use App\Traits\GetId;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use GetId;
    public function index()
    {
        if(request()->ajax()){
            $rows = User::where('role', RoleType::TEACHER)->paginate(10);
            $html = view('platform.users.table', compact('rows'))->render();
            return response()->json(['html' => $html]);
        }
        return view('platform.users.index');
    }

    public function store(Teacher $request)
    {
        try {
            $user = User::create($request->validated() + ['role' => RoleType::TEACHER]);
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '-' . $file->getClientOriginalName();
                $filePath = $file->storeAs('images', $fileName, 'public');
                $user->update(['image' => $filePath]);
            }
            \App\Models\Teacher::create(['user_id' => $user->id]);
            return response()->json(['key' => 'success' , 'msg' => 'تم إضافة المعلم بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function changeBlockStatus(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            $user->update(['is_blocked' => !$user->is_blocked]);
            return response()->json(['key' => 'success', 'msg' => 'تم تغيير حالة الحظر بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $teacher = \App\Models\Teacher::findOrFail($this->getTeacherId($id));
        $rows = SubjectStudent::whereIn('subject_id', $teacher->subjects->pluck('id'))
            ->with('student.user')
            ->get()
            ->pluck('student');
        return view('platform.users.show',compact('user', 'rows'));
    }

    public function getTeacherData($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json(['key' => 'success', 'data' => $user]);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function update(TeacherUpdate $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($request->validated());
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('images', $fileName, 'public');
                $user->update(['image' => $filePath]);
            }
            return response()->json(['key' => 'success', 'msg' => 'تم تعديل المعلم بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function delete($id)
    {
        try {
            User::findOrFail($id)->delete();
            return response()->json(['key' => 'success', 'msg' => 'تم حذف المستخدم بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }
}
