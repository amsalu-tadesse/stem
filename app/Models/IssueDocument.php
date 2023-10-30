<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueDocument extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function issue()
    {
        return $this->belongsTo(Issue::class, 'issue_id');
    }

    public function attachments()
    {
        return $this->hasMany(IssueAttachment::class);
    }

    public function category()
    {
        return $this->belongsTo(FileCategory::class, 'file_category_id');
    }
}
