<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::create([
            'user_id'=>'2',
            'feedback_id'=>'2',
            'content'=>'Comment Testing',
           
        ]);
        Comment::create([
            'user_id'=>'2',
            'feedback_id'=>'3',
            'content'=>'Comment Testing',
           
        ]);
        Comment::create([
            'user_id'=>'3',
            'feedback_id'=>'2',
            'content'=>'Comment Testing',
           
        ]);
        Comment::create([
            'user_id'=>'4',
            'feedback_id'=>'2',
            'content'=>'Comment Testing',
           
        ]);
        Comment::create([
            'user_id'=>'5',
            'feedback_id'=>'3',
            'content'=>'Comment Testing',
           
        ]);
        Comment::create([
            'user_id'=>'5',
            'feedback_id'=>'4',
            'content'=>'Comment Testing',
           
        ]);
        Comment::create([
            'user_id'=>'6',
            'feedback_id'=>'4',
            'content'=>'Comment Testing',
           
        ]);
        Comment::create([
            'user_id'=>'7',
            'feedback_id'=>'7',
            'content'=>'Comment Testing',
           
        ]);
    }
}
