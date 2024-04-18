@include('fixed.admin.head')
<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include('fixed.admin.nav')
        <div class="layout-page">
            @yield('content')
        </div>
    </div>
</div>

@include('fixed.admin.footer')
@yield('script')
</body>
</html>
