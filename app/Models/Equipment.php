<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Equipment extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, CreatedUpdatedBy;
    protected $guarded = ['id'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['name', 'description', 'center_id']);
    }

    public function lab()
    {
        return $this->belongsTo(Lab::class, 'lab_id');
    }
    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class, 'equipment_type_id');
    }
    public function measurement()
    {
        return $this->belongsTo(Measurement::class, 'measurement_id');
    }
}
