<?php

namespace App\Models;
use App\Models\OrganizationLevel;
use App\Models\OrganizationType;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Organization extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, CreatedUpdatedBy;
    protected $fillable = [
        'name',
        'description',
        'organization_type_id',
        'organization_level_id',
        'region_id',
        'zone_id',
        'created_by',
        'updated_by',
    ];


    public function organizationType()
    {
        return $this->belongsTo(OrganizationType::class);
    }

    public function organizationLevel()
    {
        return $this->belongsTo(OrganizationLevel::class);
    }
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'name',
            'description',
            'organization_type_id',
            'organization_level_id',
            'region_id',
            'zone_id',
            'created_by',
            'created_at'
        ]);
        // Chain fluent methods for configuration options
    }

}
