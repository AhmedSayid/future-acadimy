<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course as CourseReq;
use App\Http\Requests\updateCourse;
use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

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
            Course::create($data);

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
        $chapters = Chapter::where('subject_id',$course->subject_id);
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

    public function uploadVideo(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'video' => 'required|mimes:mp4,mkv,avi',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()->all(),
                ]);
            }
            if ($request->hasFile('video')) {
                $file = $request->file('video');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('videos', $fileName, 'public');

                return response()->json([
                    'success' => true,
                    'filePath' => $filePath,
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'Failed to upload the video.',
            ]);
        } catch (\Exception $e){
            $this->log($e);
            return response()->json(['key' => 'failed' , 'msg' => 'يوجد خطأ ما']);
        }
    }
}
