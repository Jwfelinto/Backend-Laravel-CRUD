<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public const MODULO = 'Módulo';
    public const INVERSOR = 'Inversor';
    public const MICROINVERSOR = 'Microinversor';
    public const ESTRUTURA = 'Estrutura';
    public const CABO_VERMELHO = 'Cabo vermelho';
    public const CABO_PRETO = 'Cabo preto';
    public const STRING_BOX = 'String Box ';
    public const CABO_TRONCO = 'Cabo Tronco';
    public const ENDCAP = 'Endcap ';

    public const ALL = [
        Tool::MODULO,
        Tool::INVERSOR,
        Tool::MICROINVERSOR,
        Tool::ESTRUTURA,
        Tool::CABO_VERMELHO,
        Tool::CABO_PRETO,
        Tool::STRING_BOX,
        Tool::CABO_TRONCO,
        Tool::ENDCAP
    ];
}
