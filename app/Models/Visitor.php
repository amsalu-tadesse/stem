<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'appointment_date' => 'date',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }
    public function institutionType()
    {
        return $this->belongsTo(InstitutionType::class, 'institution_type_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
