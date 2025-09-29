<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    protected $fillable = ['project_id', 'name', 'description', 'status', 'due_date', 'priority'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
