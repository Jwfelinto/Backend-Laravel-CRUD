<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public const ALL = [
        'modulo',
        'inversor',
        'microinversor',
        'estrutura',
        'cabo vermelho',
        'cabo preto',
        'string box',
        'cabo tronco',
        'endcap'
    ];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_tools')
            ->withPivot('quantity');
    }
}
