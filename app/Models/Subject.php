<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'grade_id',
        'name',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subjectStudents()
    {
        return $this->hasMany(SubjectStudent::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
