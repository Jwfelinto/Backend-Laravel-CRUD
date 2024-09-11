<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'uf',
    ];

    public const AC = 'AC';
    public const AL = 'AL';
    public const AP = 'AP';
    public const AM = 'AM';
    public const BA = 'BA';
    public const CE = 'CE';
    public const DF = 'DF';
    public const ES = 'ES';
    public const GO = 'GO';
    public const MA = 'MA';
    public const MT = 'MT';
    public const MS = 'MS';
    public const MG = 'MG';
    public const PA = 'PA';
    public const PB = 'PB';
    public const PR = 'PR';
    public const PE = 'PE';
    public const PI = 'PI';
    public const RJ = 'RJ';
    public const RN = 'RN';
    public const RS = 'RS';
    public const RO = 'RO';
    public const RR = 'RR';
    public const SC = 'SC';
    public const SP = 'SP';
    public const SE = 'SE';
    public const TO = 'TO';

    public const UFS = [
        Location::AC,
        Location::AL,
        Location::AP,
        Location::AM,
        Location::BA,
        Location::CE,
        Location::DF,
        Location::ES,
        Location::GO,
        Location::MA,
        Location::MT,
        Location::MS,
        Location::MG,
        Location::PA,
        Location::PB,
        Location::PR,
        Location::PE,
        Location::PI,
        Location::RJ,
        Location::RN,
        Location::RS,
        Location::RO,
        Location::RR,
        Location::SC,
        Location::SP,
        Location::SE,
        Location::TO,
    ];

    /**
     * @return HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'location_id');
    }
}
