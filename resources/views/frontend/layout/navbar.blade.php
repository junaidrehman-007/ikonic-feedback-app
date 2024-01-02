<header class="header">


    <div class="header-middle sticky-header">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>

                <a href="index.html" class="logo">
                    FeedBack App
                </a>

                <nav class="main-nav">
                    <ul class="menu sf-arrows">
                        <li class="megamenu-container active">
                            <a href="{{ route('all.feedback') }}" class="sf-with-ul">All Feedback</a>
                        </li>
                        <li>
                            <a href="{{ route('feedback.form.new') }}" class="sf-with-ul">Submit FeedBack</a>
                        </li>
                        @if (!auth()->user())
                            <li>
                                <a href="{{ route('login') }}" class="sf-with-ul">Login</a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}" class="sf-with-ul">register</a>
                            </li>
                        @endif


                    </ul><!-- End .menu -->
                </nav><!-- End .main-nav -->
            </div><!-- End .header-left -->

            <div class="header-right">
                <div class="header-search">
                    <a href="#" class="search-toggle" role="button" title="Search"><i
                            class="icon-search"></i></a>
                    <form action="#" method="get">
                        <div class="header-search-wrapper">
                            <label for="q" class="sr-only">Search</label>
                            <input type="search" class="form-control" name="q" id="q"
                                placeholder="Search in..." required>
                        </div><!-- End .header-search-wrapper -->
                    </form>
                </div><!-- End .header-search -->
            </div>

            @if (auth()->user())
              
                <div class="dropdown compare-dropdown p-2">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" data-display="static" title="Compare Products"
                        aria-label="Compare Products">
                        <i class="icon-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right p-2">
                        <ul>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('profile') }}"><i
                                        class="mdi mdi-power text-danger icon-user"></i> Profile</a>

                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div><!-- End .dropdown-menu -->
                </div>


                <div class="dropdown cart-dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" data-display="static">
                        <i class="fas fa-bell fa-xs"></i>
                        <span class="cart-count"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-cart-products">
                            <div class="product">
                                @if (isset($notifications) && count($notifications) > 0)
                                @foreach ($notifications as $notification)
                                <div class="product-cart-details">
                                    <h4 class="product-title">
                                        <a href="#"> {{ $notification->data['message'] }}</a>
                                    </h4>
                                 @if ($notification->unread())
                                                <form method="POST"
                                                    action="{{ route('notifications.markAsRead', ['notification' => $notification->id]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                  
                                                </form>
                                           
                                </div>
                                <a href="{{ route('notifications.markAsRead', $notification->id) }}" class="btn-remove" title="Mark as Read">
                                    <i class="fas fa-bell"></i> 
                                </a>
                                
                                @endif
                                @endforeach
                            @else
                                {{-- No notifications available --}}
                                <p>No notifications to display.</p>
                            @endif
                              
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            <!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-middle -->
</header><!-- End .header -->
