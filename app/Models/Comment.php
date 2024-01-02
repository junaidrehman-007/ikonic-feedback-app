<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable=[
      'user_id',
      'feedback_id',
      'date',
      'content',
    ];

    public function user(){
      return $this->hasOne(Users::class,'id','user_id');
  }
}
