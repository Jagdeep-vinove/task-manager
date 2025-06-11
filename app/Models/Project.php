<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    // Make sure timestamps are enabled
    public $timestamps = true;

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}