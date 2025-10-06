<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function courseUsers()
    {
        return $this->hasMany(CourseUser::class, 'course_id', 'id');
    }
}
