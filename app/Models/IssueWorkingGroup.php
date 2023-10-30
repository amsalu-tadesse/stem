<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class IssueWorkingGroup extends Model
{
    use HasFactory,SoftDeletes, CreatedUpdatedBy;
    protected $fillable = [
        'issue_id',
        'working_group_id',
        'created_by',
        'updated_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'issue_id',
            'working_group_id',
            'created_by',
            'updated_by',
        ]);
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class,'issue_id');
    }
    public function workingGroup()
    {
        return $this->belongsTo(WorkingGroup::class,'working_group_id');
    }
}
