<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstallationType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public const TYPES = [
        'Fibrocimento (Madeira)',
        'Fibrocimento (Metálico)',
        'Cerâmico',
        'Metálico',
        'Laje',
        'Solo'
    ];

    /**
     * @return HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'installation_type_id');
    }
}
