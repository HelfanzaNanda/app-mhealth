@extends('frontend.layouts.app', [
    'display' => 'd-none'
])
@section('content')
    <div class="bg-grey pt-23 mt-1" style="height: 100vh">
        <div style="height: 88% !important; overflow: auto">
            <div class="container-mhealth messages" style="height: 100%">
                @if ($status)
                    @foreach ($messages as $message)
                        @if ($message->pengirim == $user_id)
                            <div class="row align-items-center flex-row-reverse mb-3">    
                                <div class="card w-75 text-right" style="border-radius: 10px;">
                                    <p style="padding: 5px; margin: 0">{{ $message->message }}</p>
                                </div>
                                <div class="mr-2 text-pink">{{ $message->status == 'read' ? 'read' : 'sent' }}</div>
                            </div> 
                        @else
                            <div class="row mb-3">
                                <div class="card w-75" style="border-radius: 10px;">
                                    <p style="padding: 5px; margin: 0">{{ $message->message }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="row justify-content-center">
                        <h6>Maaf Ibu belum terdaftar di bidan mana pun</h6>
                    </div>
                @endif
                
                
            </div>
            <div class="position-fixed" style="bottom: 0; left: 0; right: 0; padding: 0 25px">
                @if ($status)
                    <p style="margin: 0; margin-bottom: 3px"><i>ibu akan di hubungkan dengan bidan <b>{{ $kunjungan->bidan->fullname }}</b></i></p>
                @endif
            <div class="form-group w-100 has-warning has-feedback " >
                <div class="input-group-mhealth">
                    <input type="text" class="bg-form-auth form-control
                    font-size-16 form-mhealth input-message" {{ !$status ? 'disabled' : '' }}
                    placeholder="Tulis pesan anda ...">
                    <span class="form-control-feedback-right">
                        <img src="{{ asset('images/icon/send-button.png') }}" width="23" height="23">
                    </span>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.input-message').on('keypress', function (e) { 
            const key = e.which
            const message = $.trim($(this).val())
            if (key == 13 && message != '') {
                sendMessage(message)
            }
        })


        function showMessage(message) {
            let cardMessage = ''
                cardMessage += '    <div class="row align-items-center flex-row-reverse mb-3">    '
                cardMessage += '        <div class="card w-75 text-right" style="border-radius: 10px;">'
                cardMessage += '            <p style="padding: 5px; margin: 0">'+message+'</p>'
                cardMessage += '        </div>'
                cardMessage += '        <div class="mr-2 text-pink">sent</div>'
                cardMessage += '    </div>'
            return cardMessage
        }

        async function sendMessage(message) {
            const url = "{{ route('pasien.modal.consultation.sendmessage') }}"
            const data = {
                message: message,
                bidanid: "{{ $status ? $kunjungan->bidanid : '' }}"
            }
            try {
                const response = await axios.post(url, data)
                if (response.data.status != 1) {
                    Swal.fire({ icon:'warning', text:res.data.msg })
                    return
                }
                $('.messages').append(showMessage(message))
                $('.input-message').val('')
            } catch (error) {
                Swal.fire({ icon:'warning', text:error })
            }    
        }
    </script>
@endpush