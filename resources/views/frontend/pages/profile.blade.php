@extends('frontend.front-master-template')


@section('content')
  <link rel="stylesheet" href="{{ asset('frontend/assets/css/profile.css') }}">

    <main class="main">
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5"
                            width="150px"
                            src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span
                            class="font-weight-bold">{{ $profile->name ?? '' }}</span><span
                            class="text-black-50">{{ $profile->email ?? '' }}</span><span> </span></div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>
                        <form action="{{ route('update.profile') }}" method="POST">
                            @csrf

                            <div class="row mt-2">
                                <div class="col-md-12"><label class="labels">Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name"
                                        value="{{ $profile->name ?? '' }}">
                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12"><label class="labels">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="enter email"
                                        value="{{ $profile->email ?? '' }}">
                                </div>
                            </div>

                            <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit">Save
                                    Profile</button></div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Change Password</h4>
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="labels">Old Password</label>
                                    <input type="password" class="form-control" name="old_password"
                                        placeholder="Old password">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="labels">New Password</label>
                                    <input type="password" class="form-control" name="new_password"
                                        placeholder="New password">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label class="labels">Confirm New Password</label>
                                    <input type="password" class="form-control" name="new_password_confirmation"
                                        placeholder="Confirm new password">
                                </div>
                            </div>
                            <div class="mt-5 text-center">
                                <button class="btn btn-primary profile-button" type="submit">Update Password</button>
                            </div>
                        </form>


                    </div>
                </div>


            </div>
            <div class="row my-5">
                <div class="col-lg-12 card">
                    <h4 class="text-center">My FeedBacks</h3>
                        <table id="datatable" class="table ">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Attachement</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($profile->feedback as $feedback)
                                    <tr>
                                        <th scope="row">{{ $feedback->id }}</th>
                                        <td>
                                            <img src="{{ $feedback->attachements }}" style="width: 50px; height: 50px">
                                        </td>
                                        <td>{{ $feedback->title }}</td>
                                        <td>{{ $feedback->category }}</td>
                                        <td>{{ $feedback->description }}</td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                        <!-- Pagination links -->
                        {{-- {{ $profile->links() }} --}}
                </div>
            </div>
        </div>
        </div>
        </div>
    </main><!-- End .main -->
@endsection
