<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'location_id',
        'installation_type_id',
    ];

    public function tools()
    {
        return $this->belongsToMany(Tool::class, 'project_tools')
            ->withPivot('quantity');
    }
}
