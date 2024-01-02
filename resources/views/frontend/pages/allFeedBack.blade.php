@extends('frontend.front-master-template')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
    .CodeMirror{
        height: 80px !important;
    }
</style>
    <main class="main">
        <div class="page-content">
            <div class="product-details-top">
                <div class="bg-light pb-5 mb-4">
                    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                        <div class="container d-flex align-items-center">
                            <ol class="breadcrumb">

                                <li class="breadcrumb-item"><a href="#">All FeedBack</a></li>

                            </ol>


                        </div><!-- End .container -->
                    </nav><!-- End .breadcrumb-nav -->

                </div><!-- End .bg-light pb-5 -->


            </div><!-- End .product-details-top -->

            <div class="container">
                <div class="row">
                  
                </div>

                <div class="row">
                    <aside class="col-lg-3 order-lg-first">
                        <div class="sidebar sidebar-shop">
                            <div class="widget widget-clean">
                                <label>Filters:</label>
                            </div>
                            <form class="row" action="{{ route('feedback.filter') }}" method="GET">
                                @csrf
                                <div class="col-lg-12">
                                    <label for="sortby">Sort by:</label>
                                    <div class="select-custom">
                                        <select id="sort-feedback" name="sort-feedback" class="form-control">
                                            <option value="date">Date</option>
                                            <option value="rating">Rating</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <label for="sortby">Category:</label>
                                    <div class="select-custom">
                                        <select id="filter-category" name="filter-category" class="form-control">
                                            <option value="">All Categories</option>
                                            @foreach ($allcategory as $category)
                                                <option value="{{ $category->category }}">{{ $category->category }}</option>
                                            @endforeach


                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </form>
                        </div>
                    </aside>
                    <div class="col-lg-9">
                        <div class="reviews">
                            <h3>Feedback ({{ $allFeedBack->count() }})</h3>
                            @foreach ($allFeedBack as $feedBack)
                                <div class="review">
                                    <div class="row no-gutters">
                                        <div class="col-auto">
                                            <img src="{{ $feedBack->attachements }}" alt="" srcset="">

                                            <span
                                                class="review-date">{{ $feedBack->created_at->diffForHumans() ?? '' }}</span>
                                        </div>
                                        <div class="col">
                                            <h3 class="product-title text-primary mb-0">{{ $feedBack->user->name ?? '' }}
                                            </h3>
                                            <h4 class="mb-0">{{ $feedBack->title ?? '' }} </h4>
                                            <span>({{ $feedBack->category ?? '' }})</span>

                                            <div class="review-content my-2">
                                                <p>{{ $feedBack->description ?? '' }}</p>
                                            </div>

                                            <div class="review-action">
                                                @if (auth()->user())
                                                    <a class="upvote mx-3" data-feedback="{{ $feedBack->id }}"
                                                        style="cursor: pointer">
                                                        <i class="icon-thumbs-up "></i>Upvote
                                                        ({{ $feedBack->upvotes ?? '' }})
                                                    </a>
                                                    <a class="downvote mx-3" data-feedback="{{ $feedBack->id }}"
                                                        style="cursor: pointer"><i
                                                            class="icon-thumbs-down downvote"></i>Downvote
                                                        ({{ $feedBack->downvotes ?? '' }})</a>
                                                @else
                                                    <a href="{{ route('login') }}">
                                                        <i class="icon-thumbs-up "></i>Upvote
                                                        ({{ $feedBack->upvotes ?? '' }})
                                                    </a>
                                                    <a href="{{ route('login') }}"><i
                                                            class="icon-thumbs-down downvote"></i>Downvote
                                                        ({{ $feedBack->downvotes ?? '' }})</a>
                                                @endif

                                                <span class="vote-count mx-3">Votes:
                                                    {{ $feedBack->upvotes + $feedBack->downvotes }}</span>

                                                <a href="#" class="toggle-comments mx-3"
                                                    data-feedback="{{ $feedBack->id }}">Comments</a>
                                            </div>
                                            <div class="comment-box" data-feedback="{{ $feedBack->id }}"
                                                style="display: none;">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        {{-- <form method="POST" action="{{ route('comments.store') }}">
                                                            @csrf
                                                            <input type="hidden" name="feedback_id"
                                                                value="{{ $feedBack->id }}">
                                                            <textarea id="comment-editor-{{ $feedBack->id }}" name="content" contenteditable="true"></textarea>
                                                            <button type="submit" class="btn btn-primary mt-2">Submit
                                                                Comment</button>
                                                        </form> --}}

                                                        <form method="POST" action="{{ route('comments.store') }}">
                                                            @csrf
                                                            <input type="hidden" name="feedback_id" value="{{ $feedBack->id }}">
                                                            
                                                            <!-- SimpleMDE textarea -->
                                                            <textarea id="simplemde-editor-{{ $feedBack->id }}" name="content"></textarea>
                                                            
                                                            <button type="submit" class="btn btn-primary mt-2">Submit Comment</button>
                                                        </form>
                                                        
                                                    </div>
                                                    <div class="card col-lg-12 my-2">
                                                        @foreach ($feedBack->comments as $comment)
                                                            <div class="card existing-comments p-3">

                                                                <h4 class="mb-0"> {{ $comment->user->name ?? '' }}</h4>
                                                                <div class="review-content">
                                                                    <p>{!! $comment->content ?? '' !!}</p>
                                                                </div>
                                                                <span
                                                                    class="comment-date text-success">{{ $comment->created_at->diffForHumans() ?? '' }}</span>

                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- End .col-auto -->
                                    </div><!-- End .row -->
                                </div><!-- End .review -->
                            @endforeach
                            <!-- Pagination -->
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <li class="page-item {{ $allFeedBack->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $allFeedBack->previousPageUrl() }}"
                                            aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                    @for ($i = 1; $i <= $allFeedBack->lastPage(); $i++)
                                        <li class="page-item {{ $i == $allFeedBack->currentPage() ? 'active' : '' }}">
                                            <a class="page-link"
                                                href="{{ $allFeedBack->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor
                                    <li class="page-item {{ $allFeedBack->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $allFeedBack->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>

                        </div><!-- End .reviews -->
                    </div>
                </div>
            </div><!-- End .container -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->





@endsection
