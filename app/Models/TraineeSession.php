<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TraineeSession extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, CreatedUpdatedBy;
    protected $guarded = ['id'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['name', 'academic_year', 'objective', 'start_date', 'end_date', 'status']);
    }

    public function traineeSessionEquipment()
    {
        return $this->hasMany(TraineeSessionEquipment::class, 'trainee_session_id');
    }

    public function center()
    {
        return $this->belongsTo(Center::class, 'center_id');
    }
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function FundType()
    {
        return $this->belongsTo(FundType::class, 'fund_type_id');
    }

    public function projectStatus()
    {
        return $this->belongsTo(ProjectStatus::class, 'project_status');
    }
}
