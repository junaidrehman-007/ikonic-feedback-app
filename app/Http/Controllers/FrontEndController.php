<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Users;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FrontEndController extends Controller
{

    function profile()
    {
        $userId = auth()->user()->id;
        $profile = Users::where('id', $userId)->with('feedback')->first();

        return view('frontend.pages.profile', get_defined_vars());
    }
    function update_profile(Request $request)
    {

        $profile = Users::where('id', auth()->user()->id)->first();
        $profile->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return back()->with('success', 'Profile Updated successfully');
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'old_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'confirmed'],
        ]);

        $auth = Auth::user()->id;
        $user = Users::find($auth);

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with('error', 'Old password is incorrect.');
        }
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }



    function all_feed_back()
    {

        $perPage = 5; // Number of feedback items per page (adjust as needed)
        $allFeedBack = Feedback::where('status','!=','rejected')->with('user', 'comments')->paginate($perPage);
        $allcategory = Feedback::get('category');

        $user = auth()->user();
        if($user){
            $notifications = $user->notifications;
            }

        return view('frontend.pages.allFeedBack', get_defined_vars());
    }

    public function feedback_filter(Request $request)
    {
        $perPage = 5;
        $allFeedBack = Feedback::query();

        // Sorting
        if ($request->input('sort-feedback') === 'rating') {
            $allFeedBack->where('status','!=','rejected')->orderBy('total_votes', 'desc');
        } else {
            $allFeedBack->where('status','!=','rejected')->orderBy('created_at', 'desc');
        }


        if ($request->input('filter-category')) {
            $allFeedBack->where('status','!=','rejected')->where('category', $request->input('filter-category'));
        }

        $allFeedBack = $allFeedBack->paginate($perPage);
        $count = $allFeedBack->total();
        $allcategory = Feedback::get('category');

        $user = auth()->user();
        if($user){
        $notifications = $user->notifications;
        }
        return view('frontend.pages.allFeedBack', get_defined_vars());
    }


    function feedback_form()
    {
        return view('frontend.pages.feedbackForm');
    }

    public function feedback_submit(Request $req)
    {

        // dd($req);
        $feedBack = new Feedback();
        $feedBack->user_id = auth()->user()->id;
        $feedBack->title = $req->title;
        $feedBack->category = $req->category;
        $feedBack->description = $req->description;

        if ($req->file('attachements')) {
            $attachements = time() . rand(9, 999) . '.' . $req->attachements->extension();
            $req->attachements->move(public_path('uploads/feedback'), $attachements);
            $feedBack->attachements = $attachements;
        }

        $feedBack->save();

        session()->flash('success_message', 'FeedBack submitted successfully!');
        return redirect()->back();
    }

    // Vote
    public function vote(Request $request)
    {

        $request->validate([
            'feedback_id' => 'required|exists:feedback,id',
            'vote_type' => 'required|in:1,-1', // 1 for upvote, -1 for downvote
        ]);

        $userId = auth()->id();
        $feedbackId = $request->input('feedback_id');
        $existingVote = Vote::where('user_id', $userId)
            ->where('feedback_id', $feedbackId)
            ->first();

        if ($existingVote) {
            return response()->json(['error' => 'You have already voted for this feedback item.'], 422);
        }
        $vote = new Vote([
            'user_id' => $userId,
            'feedback_id' => $feedbackId,
            'vote_type' => $request->input('vote_type'),
        ]);
        $vote->save();


        $feedback = Feedback::find($feedbackId);
        if ($request->input('vote_type') == 1) {
            $feedback->upvotes++;
        } elseif ($request->input('vote_type') == -1) {
            $feedback->downvotes++;
        }
        $feedback->save();

        $feedback = Feedback::find($feedbackId);
        $updatedVoteCount = $feedback->upvotes + $feedback->downvotes;
        $feedback->total_votes = $updatedVoteCount;
        $feedback->save();
        return response()->json(['vote_count' => $updatedVoteCount]);
    }
}
