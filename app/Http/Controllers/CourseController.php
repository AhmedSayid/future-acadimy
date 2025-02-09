<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course as CourseReq;
use App\Http\Requests\updateCourse;
use App\Jobs\ProcessVideoUpload;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\Student;
use App\Models\SubjectStudent;
use App\Notifications\NotifyUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CourseController extends Controller
{
    public function index($id)
    {
        if (request()->ajax()){
            $rows = Course::where('subject_id', $id)->paginate(10);
            $html = view('platform.courses.table',compact('rows'))->render();
            return response()->json(['html' => $html]);
        }
        return view('platform.courses.index',compact('id'));
    }

    public function create($id)
    {
        $chapters = Chapter::where('subject_id',$id)->get();
        return view('platform.courses.create',compact('id','chapters'));
    }

    public function store(CourseReq $request)
    {
        try {
            $data = $request->validated();
            $data['video'] = $request->input('filePath');
            $course = Course::create($data);

            $studentIds = SubjectStudent::where('subject_id',$request->subject_id)->pluck('student_id');
            $students = Student::with('user')->whereIn('id',$studentIds)->get()->pluck('user');
            $title = 'تم إضافة فيديو جديد';
            $msg = 'تم رفع فيديو جديد لمادة '.$course->subject->name;
            $route = "#";
            Notification::send($students, new NotifyUser($title, $msg, $route));
            return redirect()->route('courses.index', $request->subject_id)
                ->with('msg', 'Video added successfully.');
        }  catch (\Exception $e){
            $this->log($e);
            return back();
        }
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $chapters = Chapter::where('subject_id',$course->subject_id)->get();
        return view('platform.courses.edit',compact('course','chapters'));
    }

    public function update(updateCourse $request, $id)
    {
        try {
            $course = Course::findOrFail($id);
            $data = $request->validated();
            if($request->input('filePath')){
                $data['video_path'] = $request->input('filePath'); // Updated video path from AJAX
            }
            $course->update($data);

            return redirect()->route('courses.index', $course->subject_id)
                ->with('msg', 'Video updated successfully.');
        } catch (\Exception $e){
            $this->log($e);
            return back();
        }
    }


    public function delete($id)
    {
        try {
            Course::findOrFail($id)->delete();
            return response()->json(['key' => 'success', 'msg' => 'تم حذف الفيديو بنجاح']);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }

//    public function uploadVideo(Request $request)
//    {
//        try{
//            $validator = Validator::make($request->all(), [
//                'video' => 'required|mimes:mp4,mkv,avi',
//            ]);
//
//            if ($validator->fails()) {
//                return response()->json([
//                    'success' => false,
//                    'errors' => $validator->errors()->all(),
//                ]);
//            }
//            if ($request->hasFile('video')) {
//                $file = $request->file('video');
//
//                $originalName = $file->getClientOriginalName();
//                $sanitizedFileName = str_replace(' ', '_', $originalName);
//
//                $fileName = time() . '_' . $sanitizedFileName;
//
//                $filePath = $file->storeAs('videos', $fileName, 'public');
//
//                return response()->json([
//                    'success' => true,
//                    'filePath' => $filePath,
//                ]);
//            }
//
//            return response()->json([
//                'success' => false,
//                'error' => 'Failed to upload the video.',
//            ]);
//        } catch (\Exception $e){
//            $this->log($e);
//            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
//        }
//    }

    public function uploadVideo(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'video' => 'required|mimes:mp4,mkv,avi|max:1024000', // Max 1GB
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()]);
            }

            if ($request->hasFile('video')) {
                $file = $request->file('video');
                $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

                dd(Storage::url(asset($filename)));
                ProcessVideoUpload::dispatch($file, $filename)->afterResponse(); // Send to Queue
                return response()->json(['success' => true, 'message' => 'Video is being processed in the background.','filepath' => Storage::url(asset($filename))]);
            }
            else
                return ['key' => 'fail', 'msg' => 'no video sent'];
        }catch (\Exception $e){
            $this->log($e);
            return response()->json(['success' => false, 'error' => 'Failed to upload the video.']);
        }
    }

    public function showVideo($id): JsonResponse
    {
        $course = Course::findOrFail($id);

        if (!Storage::disk('public')->exists($course->video)) {
            return response()->json(['error' => 'فيديو غير موجود'], 404);
        }

        return response()->json([
            'video_url' => Storage::url($course->video)
        ]);
    }
}
