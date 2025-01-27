<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChapterResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\SubjectResource;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\Student;
use App\Models\Subject;
use App\Models\SubjectStudent;
use App\Notifications\NotifyUser;
use App\Traits\GetId;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    use GetId,ResponseTrait;

    public function index()
    {
        $notifications = Auth::user()->unreadNotifications;
        return response()->json([
            'key' => 'success',
            'msg' => 'تم إسترجاع الاشعارات بنجاح',
            'data' => NotificationResource::collection($notifications)
        ]);
    }

    public function store(Request $request)
    {
        try {
            $subject = Subject::findOrFail($request->subject_id);
            $user = Auth::user();

            $title = 'لقد حاول احد الطلاب تسجيل الشاشة';
            $msg = 'قام الطالب '.$user->name.'بمحاولة عمل تسجيل للشاشة في مادة '.$subject->name;

            $user = $subject->teacher?->user;

            $user->notify(new NotifyUser($title , $msg));
            return response()->json(['key' => 'success', 'msg' => 'تم ارسال الاشعار بنجاح']);
        }catch (\Exception $e){
            $this->log($e);
            return $this->failMsg('Error');
        }
    }
}
