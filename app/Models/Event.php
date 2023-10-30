<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

use Spatie\Activitylog\LogOptions;

class Event extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, CreatedUpdatedBy;


    protected $guarded = ['id'];

    public function issue()
    {
        return $this->belongsTo(Issue::class, 'issue_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['topic', 'description','address', 'start_date','end_date','status', 'issue_id','created_by','created_at']);
        // Chain fluent methods for configuration options
    }
}
