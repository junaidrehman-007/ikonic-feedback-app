<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Language;
use App\Models\Users;
use App\Models\Business;
use App\Models\Feedback;
use App\Models\Vacancy;
use App\Notifications\FeedbackUpdatedNotification;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    function index()
    {
        return view('admin.pages.dashboard.dashboard');
    }
    public function user_list()
    {

        $obj = Users::where('id', '!=', auth()->user()->id)->where('role', '!=', 'user')->get();
        return view('admin.pages.user.index', compact('obj'));
    }
    public function user_create($id)
    {
        $obj = array();
        if (isset($id) && !empty($id)) {
            $obj = Users::whereId($id)->first();
        }
        return view('admin.pages.user.form', compact('obj'));
    }
    public function user_detail(Request $req)
    {
        $obj = Users::whereId($req->id)->first();
        echo view('admin.pages.user.detail', compact('obj'));
    }
    public function user_destroy(Request $req)
    {
        Users::whereId($req->id)->delete();
        echo 1;
    }
    public function user_submit(Request $req, $id)
    {
        $imageUpdateId = $id;
        if (isset($id) && !empty($id)) {
            Users::whereId($id)->update([
                'name' => $req->name,
                'email' => $req->email,
                'phone' => $req->phone,
                'address' => $req->address,
            ]);
        } else {
            //Create
            $obj = Users::create([
                'name' => $req->name,
                'email' => $req->email,
                'role' => 'admin',
                'phone' => $req->phone,
                'address' => $req->address,
                'password' => Hash::make($req->password),

            ]);
            $imageUpdateId = $obj->id;
        }
        if ($req->file()) {
            $imageName = time() . '.' . $req->image->extension();
            $req->image->move(public_path('uploads/user'), $imageName);
            Users::whereId($imageUpdateId)->update([
                'image' => $imageName
            ]);
        }
        return redirect(route('user.list'));
    }
    public function category_list()
    {
        $obj = Category::all();
        return view('admin.pages.category.index', compact('obj'));
    }
    public function category_create($id)
    {
        $obj = array();
        if (isset($id) && !empty($id)) {
            $obj = Category::whereId($id)->first();
        }
        return view('admin.pages.category.form', compact('obj'));
    }
    public function category_detail(Request $req)
    {
        $obj = Category::whereId($req->id)->first();
        echo view('admin.pages.category.detail', compact('obj'));
    }
    public function category_destroy(Request $req)
    {
        Category::whereId($req->id)->delete();
        echo 1;
    }
    public function category_submit(Request $req, $id)
    {
        $imageUpdateId = $id;
        if (isset($id) && !empty($id)) {
            Category::whereId($id)->update([
                'name' => $req->name
            ]);
        } else {
            //Create
            $obj = Category::create([
                'name' => $req->name,
            ]);
            $imageUpdateId = $obj->id;
        }
        if ($req->file()) {
            $imageName = time() . '.' . $req->image->extension();
            $req->image->move(public_path('uploads/categories'), $imageName);
            Category::whereId($imageUpdateId)->update([
                'image' => $imageName
            ]);
        }
        return redirect(route('category.list'));
    }


    //slider 
    public function feedback_list()
    {
        $obj = Feedback::all();
        return view('admin.pages.feedback.index', compact('obj'));
    }
    public function feedback_create($id)
    {
        $obj = array();
        if (isset($id) && !empty($id)) {
            $obj = Feedback::whereId($id)->first();
        }
        return view('admin.pages.feedback.form', compact('obj'));
    }
    public function feedback_detail(Request $req)
    {
        $obj = Feedback::whereId($req->id)->first();
        echo view('admin.pages.feedback.detail', compact('obj'));
    }
    public function feedback_destroy(Request $req)
    {
        Feedback::whereId($req->id)->delete();
        echo 1;
    }
    public function feedback_submit(Request $req, $id)
    {

        $imageUpdateId = $id;
        if (isset($id) && !empty($id)) {
            Feedback::whereId($id)->update([
                'title' => $req->title,
                'category' => $req->category,
                'description' => $req->description,
            ]);
        } else {
            //Create
            $obj = Feedback::create([

                'title' => $req->title,
                'category' => $req->category,
                'description' => $req->description,
            ]);
            $imageUpdateId = $obj->id;
        }
        if ($req->file()) {
            $imageName = time() . '.' . $req->attachements->extension();
            $req->attachements->move(public_path('uploads/feedback'), $imageName);
            Feedback::whereId($imageUpdateId)->update([
                'attachements' => $imageName
            ]);
        }
        return redirect(route('feedback.list'));
    }

    public function feedback_update_status($id, $status)
    {
        // Validate the request


        // Update the feedback item's status in the database
        $feedback = Feedback::find($id);
        $feedback->status = $status;
        $feedback->save();


        $user = Users::find($feedback->user_id); // Load the user model
        $user->notify(new FeedbackUpdatedNotification($feedback));

        // Redirect back or return a response as needed
        return back()->with('success', 'Status updated successfully');
    }
}
