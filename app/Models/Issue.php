<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Issue extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, CreatedUpdatedBy;
    protected $fillable = [
        'title',
        'description',
        'private_benefit',
        'public_benefit',
        'responsible_institution',
        'responsible_person',
        'approved_message',
        'kpi',
        'rejected_message',
        'is_rejected',
        'current_secretariat',
        'issue_level',
        'start_date',
        'end_date',
        'region_id',
        'zone_id',
        'created_by',
        'updated_by',
    ];


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function kpi()
    {
        return $this->belongsTo(Kpi::class, 'kpi');
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'responsible_institution');
    }
    public function level()
    {
        return $this->belongsTo(OrganizationLevel::class, 'issue_level');
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
    public function issueWorkingGroup()
    {
        return $this->hasOne(IssueWorkingGroup::class, 'issue_id');
    }
    public function documents()
    {
        return $this->hasMany(IssueDocument::class);
    }
    // public function workingGroups()
    // {
    //     return $this->belongsTo(WorkingGroup::class,'issue_working_groups','issue_id','working_group_id');
    // }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'title',
                'description',
                'private_benefit',
                'public_benefit',
                'responsible_institution',
                'responsible_person',
                'issue_level',
                'start_date',
                'end_date',
                'created_by',
                'created_at'
            ]);
        // Chain fluent methods for configuration options
    }
}
