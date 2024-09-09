<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallationType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public const FIBROCIMENTO_MADEIRA = 'Fibrocimento (Madeira)';
    public const FIBROCIMENTO_METALICO = 'Fibrocimento (Metálico)';
    public const CERAMICO = 'Cerâmico';
    public const METALICO = 'Metálico';
    public const LAJE = 'Laje';
    public const SOLO = 'Solo';

    public const TYPES = [
        InstallationType::FIBROCIMENTO_MADEIRA,
        InstallationType::FIBROCIMENTO_METALICO,
        InstallationType::CERAMICO,
        InstallationType::METALICO,
        InstallationType::LAJE,
        InstallationType::SOLO
    ];

}
