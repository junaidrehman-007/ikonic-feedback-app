<!DOCTYPE html>
<html lang="en">

<head>
    @include('frontend.layout.metatags')
    @include('admin.assets.datatables-css')
    @include('frontend.assets.css')
</head>

<body>

    <div class="page-wrapper">
        @include('frontend.layout.navbar')
        @yield('content')
        @include('frontend.layout.footer')
    </div>
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    @include('frontend.assets.script')
    @include('admin.assets.datatables-script')


</body>

</html>
