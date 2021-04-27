@extends('frontend.layouts.app', [
    'display' => 'd-none'
])
@section('content')
    <div class="bg-grey pt-23 mt-1" style="height: 100vh; overflow: hidden">
        <div class="container-mhealth " >
            <form action="">
                @csrf
                <div class="form-group">
                    <label class="font-weight-500">Apa yang ibu rasakan hari ini ?</label>
                    <input type="text" name="" id="" class="form-control font-size-16 form-mhealth">
                </div>
                <div class="form-group">
                    <label class="font-weight-500">Apa yang ibu makan dan minum hari ini ?</label>
                    <input type="text" name="" id="" class="form-control font-size-16 form-mhealth">
                </div>
                <div class="form-group">
                    <label class="font-weight-500">Apakah ibu sudah minum obat / vitamin hari ini ?</label>
                    <input type="text" name="" id="" class="form-control font-size-16 form-mhealth">
                </div>
                <div class="form-group">
                    <label class="font-weight-500">Bagaimana kondisi janin ibu hari ini ?</label>
                    <input type="text" name="" id="" class="form-control font-size-16 form-mhealth">
                </div>
                <button class="btn btn-mhealth btn-block btn-pink text-white" type="submit">Simpan</button>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        // console.log(window.top);
    </script>
@endsection
