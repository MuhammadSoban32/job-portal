<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job_Type extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function job(){
        return $this->hasMany(job::class,'id');
    }
}
