<!doctype html>
<html lang="en">
  @include('frontend.layouts._head')
  <body>
  	@yield('content-main')
  	@include('frontend.layouts._script')
    @stack('scripts')
  </body>
</html>