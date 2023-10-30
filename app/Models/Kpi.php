<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Kpi extends Model
{
    use HasFactory, SoftDeletes,LogsActivity,CreatedUpdatedBy;
    protected $table = 'kpis';
    protected $fillable = ['name','weight', 'description'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name', 'weight', 'description', 'created_by','created_at']);
        // Chain fluent methods for configuration options
    }

    public function issues()
    {
        return $this->hasMany(Issue::class,'kpi');
    }
}
