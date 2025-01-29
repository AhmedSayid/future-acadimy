<?php

namespace App\Http\Controllers;

use App\Enums\RoleType;
use App\Models\Course;
use App\Models\ErrorLog;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\SubjectStudent;
use App\Models\Teacher;
use App\Models\User;
use App\Traits\GetId;
use Couchbase\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use GetId;

    /**
     * Display a listing of the resource.
     *
     */
    public function index($id)
    {
        if (view()->exists('dashboard.' . $id)) {
            return view('dashboard.' . $id);
        } else {
            return view('dashboard.404');
        }
    }

    public function search(Request $request)
    {
        try {
            $query = $request->input('query');
            if (Auth::user()->role == RoleType::ADMIN)
                $teachers = User::where('phone', 'LIKE', "%{$query}%")->where('role', RoleType::TEACHER)->get();
            else
                $students = User::where('phone', 'LIKE', "%{$query}%")->where('role', RoleType::STUDENT)->get();

            return response()->json([
                'teachers' => $teachers ?? 0,
                'students' => $students ?? 0,
            ]);
        } catch (Exception $e) {
            $this->log($e);
            return response()->json(['key' => 'failed', 'msg' => 'يوجد خطأ ما']);
        }
    }

    public function getHomePage()
    {
        $students_count = User::where('role', RoleType::STUDENT)->count();
        $courses_count = Course::count();
        $teachers_count = User::where('role', RoleType::TEACHER)->count();
        return view('welcome', get_defined_vars());
    }

    public function platform()
    {
        $data = [];
        if (Auth::user()->role == RoleType::ADMIN)
            $data = $this->getAdminHomeData();
        elseif (Auth::user()->role == RoleType::TEACHER)
            $data = $this->getTeacherHomeData();
        return view('platform.index' , compact('data'));
    }

    private function getAdminHomeData()
    {
        $teachers = User::where('role', RoleType::TEACHER)->latest()->get();
        $students_count = User::where('role', RoleType::STUDENT)->count();
        $videos_count = Course::count();
        $subjects_count = Subject::count();
        return [
            'teachers'  => $teachers,
            'students'  => $students_count,
            'videos'    => $videos_count,
            'subjects'  => $subjects_count,
        ];
    }

    private function getTeacherHomeData()
    {
        $teacher = Teacher::findOrFail($this->getTeacherId());
        $students = SubjectStudent::whereIn('subject_id', $teacher->subjects->pluck('id'))
            ->with('student.user')
            ->latest()
            ->get()
            ->pluck('student');
        $grades_count = Grade::where('teacher_id', $this->getTeacherId())->count();
        $courses_count = Course::whereIn('subject_id', $teacher->subjects->pluck('id'))->count();
        $subjects_count = Subject::with('grade')->where('teacher_id', $this->getTeacherId())->latest()->get();
        return [
            'students' => $students,
            'grades' => $grades_count,
            'courses' => $courses_count,
            'subjects'=> $subjects_count
        ];
    }
}
