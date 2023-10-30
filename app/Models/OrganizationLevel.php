<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;//HERE
use Spatie\Activitylog\LogOptions;
class OrganizationLevel extends Model
{
    use HasFactory, SoftDeletes, LogsActivity,CreatedUpdatedBy;//HERE
    protected $fillable = [
        'name',
        'description',
        'created_by',
        'updated_by',
    ];
    public function getActivitylogOptions(): LogOptions //HERE
    {
        return LogOptions::defaults()
        ->logOnly(['name', 'description','created_by','created_at']);
        // Chain fluent methods for configuration options
    }

    public function issues()
    {
        return $this->hasMany(Issue::class, 'issue_level');
    }
}
