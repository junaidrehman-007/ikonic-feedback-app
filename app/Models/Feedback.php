<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'category',
        'description',
        'attachements',
        'upvotes',
        'downvotes',
        'total_votes',
    ];

    public function getAttachementsAttribute()
    {
        if ($this->attributes['attachements'] == null) {
            return asset('uploads/user.jpg');
        }
        return asset('uploads/feedback') . '/' . $this->attributes['attachements'];
    }

    public function user(){
        return $this->hasOne(Users::class,'id','user_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'feedback_id','id');
    }

    public function votes(){
        return $this->hasMany(Vote::class,'feedback_id','id');
    }
        
}
