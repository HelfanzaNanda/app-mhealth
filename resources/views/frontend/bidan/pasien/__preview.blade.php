<div class="row align-items-center">
    <div class="col-2">
        <img src="{{ asset('images/profile.png') }}" class="image-chat-responsive">
    </div>
    <div class="col-9 ml-3">
        <div class="font-weight-500 font-18px block">
            {{$data->nama}}
        </div>
        <div class=" font-14">NIK: {{$data->nik}}</div>
        <div class=" font-14">Tanggal Lahir: {{$data->tanggallahir}}</div>
    </div>
</div>
<hr>
