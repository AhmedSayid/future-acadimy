<?php

namespace App\Http\Controllers;

use App\Enums\RoleType;
use App\Http\Requests\Student;
use App\Http\Requests\StudentUpdate;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\SubjectStudent;
use App\Models\Teacher;
use App\Models\User;
use App\Traits\GetId;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    use GetId;
    public function index()
    {
        if (request()->ajax()) {
            $teacher = Teacher::findOrFail($this->getTeacherId());
            $rows = SubjectStudent::whereIn('subject_id', $teacher->subjects->pluck('id'))
                ->with('student.user', 'subject')
                ->selectRaw('MIN(id) as id, student_id') // Ensures only one record per student_id
                ->groupBy('student_id')
                ->get();            $html = view('platform.students.table', compact('rows'))->render();
            return response()->json(['html' => $html]);
        }
        $subjects = Subject::where('teacher_id' , $this->getTeacherId())->get();
        $grades = Grade::where('teacher_id',$this->getTeacherId())->get();
        return view('platform.students.index', compact('subjects','grades'));
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
//            $student = \App\Models\Student::findOrFail($request->id);
            $user = User::findOrFail($request->id);
            $user->update(['is_blocked' => !$user->is_blocked]);
            return response()->json(['key' => 'success', 'msg' => 'تم تغيير حالة الحظر بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function show($id, ?string $notification_id = null)
    {
        if($notification_id){
            $notification = Auth::user()->notifications()->where('id', $notification_id)->first();
            if ($notification) {
                $notification->markAsRead();
            }
        }
        $user = User::findOrFail($id);
        $rows = SubjectStudent::with('subject')
            ->where('student_id',$this->getStudentId($id))->get();
        return view('platform.students.show',compact('user','rows'));
    }

    public function getStudentData($id)
    {
        try {
            $user = User::findOrFail($id);
            $student = \App\Models\Student::findOrFail($this->getStudentId($id));

            $subject_ids = SubjectStudent::where('student_id', $student->id)->pluck('subject_id')->toArray();
//            dd($subject_ids);
            $grade = ['id' => $student->grade->id, 'name' => $student->grade->name];

            return response()->json([
                'key' => 'success',
                'data' => [
                    'user' => $user,
                    'subject_id' => $subject_ids,
                    'grade' => $grade,
                ]
            ]);
        } catch (\Exception $e) {
            $this->log($e);
            return response()->json(['key' => 'failed', 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function update(StudentUpdate $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($request->validated());
            SubjectStudent::where('student_id' , $this->getStudentId($id))->delete();
            foreach ($request->subject_id as $subject){
                SubjectStudent::firstOrCreate([
                    'subject_id' => $subject,
                    'student_id' => $this->getStudentId($id),
                    'teacher_id' => $this->getTeacherId(),
                ]);
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
            $subject_ids = Subject::where('teacher_id',$this->getTeacherId())->get()->pluck('id');
            SubjectStudent::where('student_id',$this->getStudentId($id))->whereIn('subject_id',$subject_ids)->delete();
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
                \App\Models\Student::create(['user_id' => $student->id, 'grade_id' => $request->grade_id]);
            }

            foreach ($request->subject_id as $subject){
                SubjectStudent::firstOrCreate([
                    'subject_id' => $subject,
                    'student_id' => $this->getStudentId($student->id),
                    'teacher_id' => $this->getTeacherId(),
                ]);
            }

            if ($check)
                return response()->json(['key' => 'success' , 'msg' => 'الطالب مسجل على المنصة بالفعل وتمت اضافته الى طلابك']);

            return  response()->json(['key' => 'success' , 'msg' => 'تم تسجيل الطالب بنجاح وتمت اضافته الى طلابك']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function logout($id): JsonResponse
    {
        $user = User::findOrFail($id);

        if ($user->session_id) {
            $this->signOut($user);
        }

        return response()->json([
            'key'   => 'fail',
            'msg' => 'المستخدم ليس لديه جلسة نشطة.'
        ], 404);
    }

    private function signOut($user)
    {
        try {
            $sessionPath = config('session.files', storage_path('framework/sessions'));
            \Log::info($sessionPath);
            $sessionFile = rtrim($sessionPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $user->session_id;

            $user->device_token = null;
            $user->remember_token = null;
            $user->session_id = null;
            $user->save();

            if (File::exists($sessionFile)) {
                File::delete($sessionFile);
            }
            return response()->json([
                'key' => 'success',
                'msg' => 'تم تسجيل خروج المستخدم بنجاح.'
            ]);

        } catch (\Exception $e){
            $this->log($e);
            return response()->json([
                'key' => 'fail',
                'msg' => 'ملف الجلسة غير موجود.'
            ], 404);
        }
    }
}
