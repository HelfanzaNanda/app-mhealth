<!doctype html>
<html lang="en">
  @include('frontend.layouts._head')
  <body>
    <div class="bg-pink-2" style="height: 100vh; overflow-y: hidden;">
        <div class="row justify-content-center align-items-center h-100">
            <img src="{{ asset('images/logo-large.png') }}" width="128" height="143"> 
        </div>
    </div>
    @include('frontend.layouts._script')
  </body>
</html>