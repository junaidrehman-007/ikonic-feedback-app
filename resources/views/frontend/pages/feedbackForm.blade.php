@extends('frontend.front-master-template')


@section('content')
    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container">
                <ol class="breadcrumb">

                    <li class="breadcrumb-item active" aria-current="page">FeedBack</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->


        <div class="page-content pb-0">
            <div class="container">
                <div class="row">

                    <div class="col-lg-12">
                        <h2 class="title mb-1">Your Feedback</h2><!-- End .title mb-2 -->
                        <p class="mb-2">Use the form below to to enter your feedback!</p>

                        <form class="contact-form mb-3" action="{{ route('feedback.submit') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="title" class="sr-only">Title</label>
                                    <input type="text" class="form-control" name="title" id="title"
                                        placeholder="Title *" required>
                                </div><!-- End .col-sm-6 -->

                                <div class="col-sm-6">
                                    <label for="category" class="sr-only">Category</label>
                                    {{-- <input type="text" class="form-control" name="category" id="category"
                                        placeholder="category *" required> --}}
                                        <select name="category" id="category"
                                        placeholder="category *" class="form-control">
                                            <option value="">Select Category</option>
                                            <option value="Product Quality">Product Quality</option>
                                            <option value="Customer Service">Customer Service</option>
                                            <option value="Shipping and Delivery">Shipping and Delivery</option>
                                            <option value="Price and Value">Price and Value</option>
                                            <option value="Product Features">Product Features</option>
                                            <option value="Ease of Use">Ease of Use</option>
                                            <option value="Product Packaging">Product Packaging</option>
                                            <option value="Product Safety">Product Safety</option>
                                            <option value="Product Suggestions">Product Suggestions</option>
                                            <option value="Overall Experience">Overall Experience</option>



                                           


                                        </select>
                                </div><!-- End .col-sm-6 -->
                            </div><!-- End .row -->



                            <label for="description" class="sr-only">Description</label>
                            <textarea class="form-control" cols="30" rows="4" name="description" id="description" required
                                placeholder="Description *"></textarea>

                            <label for="">Attachements</label>
                            <input type="file" class="form-control" name="attachements" id="attachements"
                                placeholder="Attachements *" required>

                            <button type="submit" class="btn btn-outline-primary-2 btn-minwidth-sm">
                                <span>SUBMIT</span>
                                <i class="icon-long-arrow-right"></i>
                            </button>
                        </form><!-- End .contact-form -->
                    </div><!-- End .col-lg-6 -->
                </div><!-- End .row -->

                <hr class="mt-4 mb-5">


            </div><!-- End .container -->

        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection
