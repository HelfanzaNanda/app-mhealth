@extends('frontend.layouts.app', [
    'display' => 'd-none'
])
@section('content')
    <div class="bg-grey pt-23 mt-1" style="height: 100vh">
        <div style="height: 88% !important; overflow: auto">
            <div class="container-mhealth messages" style="height: 100%">
                <div class="row flex-column mb-3">
                    <p style="margin: 0" class="text-active-pink">bidan a</p>
                    <div class="card w-75" style="border-radius: 10px;">
                        <p style="padding: 5px; margin: 0">sjdjnsndjs</p>
                    </div>
                </div>
                
                <div class="d-flex flex-column text-right mb-3">
                    <p style="margin: 0" class="text-active-pink">Anda</p>
                    <div class="row flex-row-reverse ">    
                        <div class="card w-75" style="border-radius: 10px;">
                            <p style="padding: 5px; margin: 0">sjdjnsndjs</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group w-100 has-warning has-feedback position-fixed" 
            style="bottom: 0; right: 0; padding: 0 25px">
                <div class="input-group-mhealth">
                    <input type="text" class="bg-form-auth form-control
                    font-size-16 form-mhealth input-message"
                    placeholder="Tulis pesan anda ...">
                    <span class="form-control-feedback-right">
                        <img src="{{ asset('images/icon/send-button.png') }}" width="23" height="23">
                    </span>
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
                $('.messages').append(showMessage(message))
                $('.input-message').val('')
            }
        })


        function showMessage(message) {
            let cardMessage = ''
                cardMessage += '<div class="d-flex flex-column text-right mb-3">'
                cardMessage += '    <p style="margin: 0" class="text-active-pink">Anda</p>'
                cardMessage += '    <div class="row flex-row-reverse ">    '
                cardMessage += '        <div class="card w-75" style="border-radius: 10px;">'
                cardMessage += '            <p style="padding: 5px; margin: 0">'+message+'</p>'
                cardMessage += '        </div>'
                cardMessage += '    </div>'
                cardMessage += '</div>'
            return cardMessage
        }
    </script>
@endpush