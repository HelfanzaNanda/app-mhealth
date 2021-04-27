@extends('frontend.layouts.master')

@section('content-main')
@include('frontend.layouts._frame_modal')
  @yield('content')
  <div class="{{ $display ?? 'd-block' }}">
    @include('frontend.layouts._navigation_pasien')
  </div>
@endsection

