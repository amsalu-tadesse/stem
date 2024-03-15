<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectStatus extends Model
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
}
