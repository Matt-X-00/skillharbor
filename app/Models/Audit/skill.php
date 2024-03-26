<?php

namespace App\Models\Audit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class skill extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(category::class, 'skill_category_id');
    }

    public function jcps()
    {
        return $this->belongsToMany(jcp::class)->withPivot('user_rating', 'supervisor_rating');
    }
}