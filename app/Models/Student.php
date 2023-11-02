<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Student extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, CreatedUpdatedBy;
    protected $guarded = ['id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'created_by',
                'created_at'
            ]);
    }
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_session');
    }
}
