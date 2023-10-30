<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class WorkingGroupMember extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, CreatedUpdatedBy;


    public function workingGroup()
    {
        return $this->belongsTo(WorkingGroup::class, 'working_group_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'description',

                'organization_level_id',
                'region_id',
                'zone_id',
                'created_by', 'created_at'
            ]);
        // Chain fluent methods for configuration options
    }
}
