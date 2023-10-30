<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Subscription extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    protected $fillable = [
        'email',
        'level',
        'token',
        'updated_by',
    ];
    public function level(){
        return $this->belongsTo(OrganizationLevel::class);
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['email','created_at']);
        // Chain fluent methods for configuration options
    }}
