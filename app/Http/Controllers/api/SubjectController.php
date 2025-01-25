<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChapterResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\SubjectResource;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\Subject;
use App\Models\SubjectStudent;
use App\Traits\GetId;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    use GetId,ResponseTrait;
    public function getSubjects()
    {
        $subjectIds = SubjectStudent::where('student_id',$this->getStudentId())->get()->pluck('subject_id');
        $subjects = Subject::whereIn('id',$subjectIds)->get();
        return $this->successData(SubjectResource::collection($subjects));
    }

    public function getChapters($id)
    {
        $chapters = Chapter::where('subject_id',$id)->get();
        return $this->successData(ChapterResource::collection($chapters));
    }

    public function getVideos($subject_id,?int $id = null)
    {
        $videos = Course::with('subject', 'chapter')->where('subject_id',$subject_id)->when($id,function ($q) use ($id) {
            $q->where('chapter_id',$id);
        })->get();
        return $this->successData(CourseResource::collection($videos));
    }
}
