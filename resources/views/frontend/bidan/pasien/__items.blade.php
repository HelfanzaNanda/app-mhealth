@foreach($items as $item)
<div class="row align-items-center" onclick="openFrame('{{route('bidan.pasien.modal.profile'))}}')">
    <div class="col-2">
        <img src="{{ asset('images/profile.png') }}" class="image-chat-responsive">
    </div>
    <div class="col-9 ml-3">
        <div class="font-weight-500 font-18px block">
            {{$item->pasien->nama}}
        </div>
        <div class="d-inline-block text-pink font-14">{{$item->pasien->nik}}</div>
    </div>
</div>
<hr>
@endforeach