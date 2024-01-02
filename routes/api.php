<?php

use App\Http\Controllers\StripeController;
use App\Models\Business;
use App\Models\Event;
use App\Models\PasswordReset;
use App\Models\Users;
use App\Models\Image;
use App\Models\Job;
use App\Models\Product;
use App\Models\Service;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Stripe\Stripe;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login/token', function (Request $request) {

    requestValidate($request, [
        "email" => "required|email|exists:users,email",
        "password" => "required"
    ]);

    $user = Users::where('email', $request->email)->first();
    if (!$user)
        return response(['status' => false, 'message' => 'Email address does not exist'], 200);

    if (!Hash::check($request->password, $user->password))
        return response(['status' => false, 'message' => 'Invalid email or password. Please try again'], 200);


    return ['code' => 200, 'status' => true, 'message' => 'Login Successfully', 'data' => $user, 'access_token' => $user->createToken($request->email)->plainTextToken];
});

Route::post('register', function (Request $request) {

    requestValidate($request, [
        "email" => "required",
        "name" => "required",
        "password" => "required",
        "role" => "in:customer,admin,business",
        "country" => "required",
        "city" => "required",
        "state" => "required"

    ]);

    $user = new Users;

    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->phone = '';
    $user->role = $request->role;
    $user->country = $request->country;
    $user->city = $request->city;
    $user->state = $request->state;
    $user->address = '';
    // $user->image = $request->name;

    if ($request->file()) {
        $imageName = rand(9, 99999) . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/user'), $imageName);
        $user->image = $imageName;
    }
    $token = rand(0, 9999);
    PasswordReset::insert([
        'email' => $user->email,
        'token' => $token
    ]);
    Mail::send('mails.forgot-password', ['user' => $user, 'token' => $token], function ($m) use ($user, $token) {
        $m->from('verify@app.com', 'Das Wunder');

        $m->to($user->email, $user->name)->subject('OTP Verification Email');
    });
    $user->save();

    return ['status' => true, 'message' => 'OTP has been sent on your Email please check your inbox, also check spam list'];
});
Route::post('forgot-email', function (Request $request) {

    requestValidate($request, [
        "email" => "required|email|exists:users,email"

    ]);

    $user = Users::where('email', $request->email)->first();
    if ($user) {
        $token = rand(0, 9999);
        PasswordReset::insert([
            'email' => $user->email,
            'token' => $token
        ]);
        Mail::send('mails.forgot-password', ['user' => $user, 'token' => $token], function ($m) use ($user, $token) {
            $m->from('forgot@app.com', 'Das Wunder');

            $m->to($user->email, $user->name)->subject('Forgot Password Token');
        });


        return ['status' => true, 'message' => 'OTP has been sent on your Email please check your inbox, also check spam list'];
    } else {

        return ['status' => false, 'message' => "The Email you provided doesn't belong to any account"];
    }

    return ['status' => true, 'message' => 'OTP has been sent on your Email please check your inbox, also check spam list'];
});
Route::post('otp-verify', function (Request $request) {

    requestValidate($request, [
        "token" => "required",
        "email" => "required"

    ]);

    $token = PasswordReset::where('token', $request->token)->first();
    if ($token) {
        Users::where('email', $token->email)->update([
            'is_verified' => 1
        ]);
        PasswordReset::where('token', $request->token)->delete();

        $user = Users::where('email', $request->email)->first();
        return ['code' => 200, 'status' => true, 'message' => 'Registered Successfully', 'data' => $user, 'access_token' => $user->createToken($request->email)->plainTextToken];
    } else {

        return ['status' => false, 'message' => 'Invalid OTP'];
    }

    // return ['status' => true, 'message' => 'User Registered Successfully'];
});



Route::post('reset-password', function (Request $request) {

    requestValidate($request, [
        "token" => "required",
        "password" => "required"

    ]);

    $token = PasswordReset::where('token', $request->token)->first();
    if ($token) {
        Users::where('email', $token->email)->update([
            'password' => Hash::make($request->password)
        ]);
        PasswordReset::where('token', $request->token)->delete();
                $user = Users::where('email', $token->email)->first();

        return ['status' => true, 'message' => 'Password Reset Successfully','data' => $user, 'access_token' => $user->createToken($token->email)->plainTextToken];
    } else {

        return ['status' => true, 'message' => 'Invalid OTP'];
    }

    // return ['status' => true, 'message' => 'Password Reset Successfully'];
});
Route::group(['middleware' => 'auth:sanctum'], function () {


    Route::get('profile', function (Request $request) {
        $user =  auth()->user();
        $user['access_token'] = $user->createToken($user->email)->plainTextToken;

        return ['code' => 200, 'status' => true, 'message' => 'User Profile Information', 'data' => $user];
    });

    Route::post('profile', function (Request $request) {

        requestValidate($request, [
            "phone" => "required",
            "name" => "required",
            "address" => "required",
            "country" => "required",
            "city" => "required",
            "state" => "required"

        ]);

        $user = Users::find(auth()->user()->id);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->state = $request->state;
        // $user->image = $request->name;

        if ($request->file()) {
            $imageName = rand(9, 99999) . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/user'), $imageName);
            $user->image = $imageName;
        }
        $user->save();

        return ['status' => true, 'message' => 'Profile Updated Successfully'];
    });


    Route::post('upload/multiple/files', function (Request $request) {
        if (!$request->hasFile('files')) {
            return ['status' => false, 'message' => 'upload_file_not_found'];
        }
        if ($request->file('business_cover')) {
            $imageName = rand(9, 99999) . '.' . $request->business_cover->extension();
            $request->business_cover->move(public_path('uploads/business'), $imageName);
            Business::where('id', $request->business_id)->update([
                'business_cover' => $imageName
            ]);
        }
        if ($request->file('business_logo')) {
            $imageName = rand(9, 99999) . '.' . $request->business_logo->extension();
            $request->business_logo->move(public_path('uploads/business'), $imageName);
            Business::where('id', $request->business_id)->update([
                'business_logo' => $imageName
            ]);
        }
        $allowedfileExtension = ['pdf', 'jpg', 'png'];
        $files = $request->file('files');
        $errors = [];
        if (count($files) > 0) :
            foreach ($files as $mediaFiles) {

                $name = rand(9, 99999) . '.' . $mediaFiles->extension();
                $mediaFiles->move(public_path('uploads/business'), $name);

                //store image file into directory and db
                $save = new Image();
                $save->image = $name;
                $save->business_id = $request->business_id;
                $save->save();
            }
            return ['status' => true, 'message' => 'File Uploaded Successfully'];

        else :
            return ['status' => false, 'message' => 'files must be in array'];
        endif;
    });

    //Events
    Route::post('event', function (Request $request) {

        $update_id = 0;
        requestValidate($request, [
            "title" => "required",

        ]);
        if ($request->event_id) {
            $update_id = $request->event_id;
            Event::whereId($request->event_id)->update($request->all());
        } else {
            $update_id = Event::insertGetId([
                'title' => $request->title,
                'description' => $request->description,
                'timeline' => $request->timeline,
                'date' => $request->date,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'location' => $request->location
            ]);
        }

        if ($request->file('image')) {
            $imageName = rand(9, 99999) . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/events'), $imageName);
            Event::where('id', $update_id)->update([
                'image' => $imageName
            ]);
        }
        $user = auth()->user();

        return ['status' => true, 'message' => 'Congratulations! Event is created sucessfully'];
    });

    Route::get('event', function (Request $request) {

        $user = auth()->user();
        return  Event::paginate(15);
    });
    Route::get('event/{id}', function (Request $request, $id) {

        $user = auth()->user();
        return  Event::where('id', $id)->first();
    });



    //Services
    Route::post('service', function (Request $request) {

        $update_id = 0;
        requestValidate($request, [
            "title" => "required",
            "category" => "required",
            "price" => "required",
        ]);
        if ($request->service_id) {
            $update_id = $request->service_id;
            Service::whereId($request->service_id)->update($request->all());
        } else {
            $update_id = Service::insertGetId([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'price' => $request->price,
                'location' => $request->location
            ]);
        }

        if ($request->file('image')) {
            $imageName = rand(9, 99999) . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/services'), $imageName);
            Service::where('id', $update_id)->update([
                'image' => $imageName
            ]);
        }
        $user = auth()->user();

        return ['status' => true, 'message' => 'Congratulations! Service is created sucessfully'];
    });

    Route::get('service', function (Request $request) {

        $user = auth()->user();
        return  Service::paginate(15);
    });
    Route::get('service/{id}', function (Request $request, $id) {

        $user = auth()->user();
        return  Service::where('id', $id)->first();
    });



    //Products
    Route::post('product', function (Request $request) {

        $update_id = 0;
        requestValidate($request, [
            "title" => "required",
            "category" => "required",
            "price" => "required",
        ]);
        if ($request->product_id) {
            $update_id = $request->product_id;
            Product::whereId($request->product_id)->update($request->all());
        } else {
            $update_id = Product::insertGetId([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'price' => $request->price,
                'location' => $request->location
            ]);
        }

        if ($request->file('image')) {
            $imageName = rand(9, 99999) . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            Product::where('id', $update_id)->update([
                'image' => $imageName
            ]);
        }
        $user = auth()->user();

        return ['status' => true, 'message' => 'Congratulations! Product is created sucessfully'];
    });

    Route::get('product', function (Request $request) {

        $user = auth()->user();
        return  Product::paginate(15);
    });
    Route::get('product/{id}', function (Request $request, $id) {

        $user = auth()->user();
        return  Product::where('id', $id)->first();
    });


    //Jobs
    Route::post('job', function (Request $request) {

        $update_id = 0;
        requestValidate($request, [
            "title" => "required",
            "company_name" => "required",
            "salary" => "required",
            "industry" => "required",
            "address" => "required",

        ]);
        if ($request->job_id) {
            $update_id = $request->job_id;
            Job::whereId($request->job_id)->update($request->all());
        } else {
            $update_id = Job::insertGetId([
                'title' => $request->title,
                'description' => $request->description,
                'salary' => $request->salary,
                'company_name' => $request->company_name,
                'industry' => $request->industry,
                'address' => $request->address,
                'futher_information' => $request->futher_information,
                'location' => $request->location
            ]);
        }

        if ($request->file('image')) {
            $imageName = rand(9, 99999) . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/jobs'), $imageName);
            Job::where('id', $update_id)->update([
                'image' => $imageName
            ]);
        }
        $user = auth()->user();

        return ['status' => true, 'message' => 'Congratulations! Job is created sucessfully'];
    });

    Route::get('job', function (Request $request) {

        $user = auth()->user();
        return  Job::paginate(15);
    });
    Route::get('job/{id}', function (Request $request, $id) {

        $user = auth()->user();
        return  Job::where('id', $id)->first();
    });
});
