@include('fixed.head')
<body>
    @include('fixed.nav')

    @yield('content')

    @include('fixed.footer')
    @yield('script')
</body>
</html>
