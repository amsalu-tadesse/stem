<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class GroupLab extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, CreatedUpdatedBy;
    protected $guarded = [
        'id',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'group_id',
                'lab_id',

            ]);
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function lab()
    {
        return $this->belongsTo(Lab::class, 'lab_id');
    }
}
