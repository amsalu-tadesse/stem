<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Attachment;

class Document extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category()
    {
        return $this->belongsTo(FileCategory::class, 'file_category_id');
    }

    public function issueObject()
    {
        return $this->belongsTo(Issue::class,'issue');
    }
}
