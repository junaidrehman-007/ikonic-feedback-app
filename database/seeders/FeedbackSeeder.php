<?php

namespace Database\Seeders;

use App\Models\Feedback;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Feedback::create([
            'user_id' => '2',
            'title' => 'Product Quality',
            'category' => 'Product Quality',
            'description' => 'Descripition Testing feedback for product',
            'attachements' => '',
            'status' => 'approved',
            'upvotes' => '3',
            'downvotes' => '2',
            'total_votes' => '5',
        ]);
        Feedback::create([
            'user_id' => '3',
            'title' => 'Customer Service',
            'category' => 'Customer Service',
            'description' => 'Descripition Testing feedback for product',
            'attachements' => '',
            'status' => 'approved',
            'upvotes' => '5',
            'downvotes' => '5',
            'total_votes' => '10',
        ]);
        Feedback::create([
            'user_id' => '4',
            'title' => 'Customer Service',
            'category' => 'Customer Service',
            'description' => 'Descripition Testing feedback for product',
            'attachements' => '',
            'status' => 'approved',
            'upvotes' => '3',
            'downvotes' => '3',
            'total_votes' => '6',
        ]);
        Feedback::create([
            'user_id' => '5',
            'title' => 'Price and Value',
            'category' => 'Price and Value',
            'description' => 'Descripition Testing feedback for product',
            'attachements' => '',
            'status' => 'approved',
            'upvotes' => '3',
            'downvotes' => '4',
            'total_votes' => '7',
        ]);
        Feedback::create([
            'user_id' => '6',
            'title' => 'Price and Value',
            'category' => 'Price and Value',
            'description' => 'Descripition Testing feedback for product',
            'attachements' => '',
            'status' => 'approved',
            'upvotes' => '10',
            'downvotes' => '5',
            'total_votes' => '15',
        ]);
        Feedback::create([
            'user_id' => '7',
            'title' => 'Price and Value',
            'category' => 'Price and Value',
            'description' => 'Descripition Testing feedback for product',
            'attachements' => '',
            'status' => 'approved',
            'upvotes' => '4',
            'downvotes' => '4',
            'total_votes' => '8',
        ]);
        Feedback::create([
            'user_id' => '8',
            'title' => 'Product Suggestions',
            'category' => 'Product Suggestions',
            'description' => 'Descripition Testing feedback for product',
            'attachements' => '',
            'status' => 'approved',
            'upvotes' => '3',
            'downvotes' => '2',
            'total_votes' => '5',
        ]);
        Feedback::create([
            'user_id' => '9',
            'title' => 'Product Suggestions',
            'category' => 'Product Suggestions',
            'description' => 'Descripition Testing feedback for product',
            'attachements' => '',
            'status' => 'approved',
            'upvotes' => '5',
            'downvotes' => '2',
            'total_votes' => '7',
        ]);
        Feedback::create([
            'user_id' => '10',
            'title' => 'Product Safety',
            'category' => 'Product Safety',
            'description' => 'Descripition Testing feedback for product',
            'attachements' => '',
            'status' => 'approved',
            'upvotes' => '8',
            'downvotes' => '2',
            'total_votes' => '10',
        ]);
        Feedback::create([
            'user_id' => '11',
            'title' => 'Shipping and Delivery',
            'category' => 'Shipping and Delivery',
            'description' => 'Descripition Testing feedback for product',
            'attachements' => '',
            'status' => 'approved',
            'upvotes' => '9',
            'downvotes' => '1',
            'total_votes' => '10',
        ]);
    }
}
