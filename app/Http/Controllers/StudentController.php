<?php

namespace App\Http\Controllers;

use App\Enums\RoleType;
use App\Http\Requests\Student;
use App\Http\Requests\StudentUpdate;
use App\Models\Subject;
use App\Models\SubjectStudent;
use App\Models\Teacher;
use App\Models\User;
use App\Traits\GetId;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    use GetId;
    public function index()
    {
        if (request()->ajax()) {
            $teacher = Teacher::findOrFail($this->getTeacherId());
            $rows = SubjectStudent::whereIn('subject_id', $teacher->subjects->pluck('id'))
                ->with('student.user')
                ->get()
                ->pluck('student');
            $html = view('platform.students.table', compact('rows'))->render();
            return response()->json(['html' => $html]);
        }
        $subjects = Subject::where('teacher_id' , $this->getTeacherId())->get();
        return view('platform.students.index', compact('subjects'));
    }

    public function store(Student $request)
    {
        try {
            $user = User::create($request->validated() + ['role' => RoleType::STUDENT]);
            \App\Models\Student::create(['user_id' => $user->id]);
            return response()->json(['key' => 'success' , 'msg' => 'تم إضافة الطالب بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function changeBlockStatus(Request $request)
    {
        try {
            $student = \App\Models\Student::findOrFail($request->id);
            $user = User::findOrFail($student->user_id);
            $user->update(['is_blocked' => !$user->is_blocked]);
            return response()->json(['key' => 'success', 'msg' => 'تم تغيير حالة الحظر بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function show($id)
    {
        $user = \App\Models\Student::findOrFail($id)->user;
        $rows = SubjectStudent::with('subject')
            ->where('student_id',$id)->get();
        return view('platform.students.show',compact('user','rows'));
    }

    public function getStudentData($id)
    {
        try {
            $student = \App\Models\Student::findOrFail($id);
            $user = User::findOrFail($student->user_id);
            return response()->json(['key' => 'success', 'data' => $user]);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function update(StudentUpdate $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($request->validated());
            return response()->json(['key' => 'success', 'msg' => 'تم تعديل المعلم بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function delete($id)
    {
        try {
            SubjectStudent::where('student_id',$id)->first()->delete();
            return response()->json(['key' => 'success', 'msg' => 'تم حذف المستخدم بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }
    public function addStudent(Student $request)
    {
        try {
            $student = User::where(['phone' => $request->phone , 'role' => RoleType::STUDENT])->first();
            $check = true;
            if(!$student){
                $check = false;
                $student = User::create($request->validated() + ['role' => RoleType::STUDENT]);
                \App\Models\Student::create(['user_id' => $student->id]);
            }

            SubjectStudent::firstOrCreate([
                'subject_id' => $request->subject_id,
                'student_id' => $this->getStudentId($student->id),
                'teacher_id' => $this->getTeacherId(),
            ]);

            if ($check)
                return response()->json(['key' => 'success' , 'msg' => 'الطالب مسجل على المنصة بالفعل وتمت اضافته الى طلابك']);

            return  response()->json(['key' => 'success' , 'msg' => 'تم تسجيل الطالب بنجاح وتمت اضافته الى طلابك']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }
}
