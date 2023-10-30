<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function document()
    {
        return $this->belongsTo(Document::class, 'id');    
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
