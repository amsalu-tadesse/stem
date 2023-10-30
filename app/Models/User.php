<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\CreatedUpdatedBy;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;




class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, CreatedUpdatedBy,SoftDeletes,LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'mobile',
        'password',
        'password_changed',
        'status',
        'organization_id',
        'is_superadmin',
        'created_by',
        'updated_by',
    ];
     protected $with = ['organization','roles'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        //'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */


    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function workingGroupMembers()
    {
        return $this->hasMany(WorkingGroupMember::class);
    }

    protected static $logAttributes = ['*'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'first_name',
            'middle_name',
            'last_name',
            'email',
            'mobile',
            'is_superadmin',
            'organization_id',
            'status',
            'created_by',
            'updated_by',
            'roles',
            'permissions',
        ])
        ->useLogName('users');
    // ->dontLogIfAttributesChangedOnly(['password']);
    // ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }

}
