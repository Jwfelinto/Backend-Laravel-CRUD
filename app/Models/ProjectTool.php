<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectTool extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'tool_id',
        'quantity'
    ];
}
