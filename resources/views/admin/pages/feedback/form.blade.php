@extends('admin.admin-master-template')
@section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">Slider</h4>
                        </div>

                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <?php
                                $update_id = 0;
                                
                                if (isset($obj->id) && !empty($obj->id)) {
                                    $update_id = $obj->id;
                                }
                                ?>
                                <form class="" action="{{ route('admin.feedback.submit', $update_id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" name="title"
                                                value="<?= isset($obj->title) && !empty($obj->title) ? $obj->title : '' ?>"
                                                class="form-control" required placeholder="Type something" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <input type="text" name="category"
                                                value="<?= isset($obj->category) && !empty($obj->category) ? $obj->category : '' ?>"
                                                class="form-control" required placeholder="Type something" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" name="description"
                                                value="<?= isset($obj->description) && !empty($obj->description) ? $obj->description : '' ?>"
                                                class="form-control" required placeholder="Type something" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <label>Attachement</label>
                                            <div>
                                                <?php $attachements = isset($obj->attachements) && !empty($obj->attachements) ? $obj->attachements : ''; ?>
                                                <input name="attachements" data-default-file="<?= $attachements ?>" type="file"
                                                    class="dropify" data-height="100" />
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                Submit
                                            </button>
                                            <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div> <!-- end col -->


                </div> <!-- end row -->


            </div>
            <!-- container-fluid -->

        </div>
        <!-- content -->

        <footer class="footer">
            © 2019 - 2020 Stexo <span class="d-none d-sm-inline-block"> - Crafted with <i
                    class="mdi mdi-heart text-danger"></i> by Themesdesign</span>.
        </footer>

    </div>
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->
@endsection
