<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    public function job_type(){
        return $this->belongsTo(job_type::class,'job_type_id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function jobApplication(){
        return $this->hasMany(JobApplication::class,'job_id');
    }

    public function application(){
        return $this->hasMany(JobApplication::class);
    }

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
}
