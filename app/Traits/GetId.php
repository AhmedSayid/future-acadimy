<?php

namespace App\Traits;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

trait GetId
{
    public function getTeacherId(?int $id = null)
    {
        return Teacher::where('user_id',$id??Auth::id())->first()?->id;
    }

    public function getStudentId(?int $id = null)
    {
        return Student::where('user_id',$id??Auth::id())->first()?->id;
    }
}
