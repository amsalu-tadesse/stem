<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class WorkingGroup extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, CreatedUpdatedBy;
    protected $fillable = [
        'name',
        'description',
        'organization_level_id',
        'region_id',
        'zone_id',
        'created_by',
        'updated_by',
    ];
    public function organizationLevel()
    {
        return $this->belongsTo(OrganizationLevel::class);
    }
    public function issues()
    {
        return $this->belongsTo(Issue::class, 'issue_working_groups', 'working_group_id', 'issue_id');
    }
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
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
