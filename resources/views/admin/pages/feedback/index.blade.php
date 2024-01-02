@extends('admin.admin-master-template-with-datatable')
@section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <h4 class="mt-0 header-title d-flex" style="justify-content: space-between;">
                                    <span>
                                        FeedBack
                                    </span>
                                    <a href="{{ route('feedback.create', 0) }}" class="btn btn-primary">Add New</a>
                                </h4>
                                <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Attachement</th>
                                            <th>User</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        @foreach ($obj as $key => $val)
                                            <tr>

                                                <td><img src="<?= $val->attachements ?>" height="50" width="50"
                                                        class="img-fluid img-thumbnail" alt=""></td>
                                                <td>{{ $val->user->name }}</td>
                                                <td>{{ $val->title }}</td>
                                                <td>{{ $val->category }}</td>
                                                <td>{{ $val->description }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-danger">{{ $val->status ?? '' }}</button>
                                                        <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item " href="{{ route('feedback.update.status',['feedbackId' => $val->id,'status' => 'pending']) }}" >Pending</a>
                                                            <a class="dropdown-item " href="{{ route('feedback.update.status',['feedbackId' => $val->id,'status' => 'approved']) }}" >Approved</a>
                                                            <a class="dropdown-item " href="{{ route('feedback.update.status',['feedbackId' => $val->id,'status' => 'rejected']) }}" >Rejected</a>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    {{-- <form method="POST"
                                                        action="{{ route('feedback.update.status', $val->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <select name="status">
                                                            <option value="pending"
                                                                {{ $val->status === 'pending' ? 'selected' : '' }}>Pending
                                                            </option>
                                                            <option value="approved"
                                                                {{ $val->status === 'approved' ? 'selected' : '' }}>Approved
                                                            </option>
                                                            <option value="rejected"
                                                                {{ $val->status === 'rejected' ? 'selected' : '' }}>Rejected
                                                            </option>
                                                        </select>
                                                        <button type="submit">Update Status</button>
                                                    </form> --}}
                                                </td>


                                                <td>
                                                    <a class="" href="{{ route('feedback.create', $val->id) }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a class=" delete_action" rel="{{ $val->id }}" crud="slider"
                                                        href="javascript:void(0);">
                                                        <i class="fa fa-times"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div>
            <!-- container-fluid -->

        </div>
        <!-- content -->



    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".update-status").click(function(e) {
                e.preventDefault();
    
                var feedbackId = $(this).data("feedback");
                var newStatus = $(this).data("status");
    
                // Make an AJAX request to update the status
                $.ajax({
                    url: '/feedback/update/status/' + feedbackId ,
                    method: 'PATCH',
                    data: {
                        status: newStatus,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // Handle the success response, if needed
                        console.log("Status updated successfully.");
                    },
                    error: function(xhr) {
                        // Handle any errors, if needed
                        console.error("Error updating status: " + xhr.statusText);
                    }
                });
            });
        });
    </script>
    
@endsection
