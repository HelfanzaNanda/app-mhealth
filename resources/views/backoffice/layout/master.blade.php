<!DOCTYPE html>
<html>
<head>
  <title>{{config('app.name')}}</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- CSRF Token -->
  <meta name="_token" content="{{ csrf_token() }}">
  
  <link rel="shortcut icon" href="{{ asset('/favicon.png') }}">

  <!-- plugin css -->
  <link href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
  <!-- end plugin css -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

  @stack('plugin-styles')
  <style type="text/css">
    ::-webkit-scrollbar{
      height: 5px;
      width: 5px;
      background: #f1f1f1;
    }
    ::-webkit-scrollbar-thumb{
      background: lightgrey;
      border-radius: 2px;
    }
    .table-sm th, .table-sm td{
      padding: .75rem .75rem!important;
    }
    .sidebar{
      width: 210px;
    }
    .main-wrapper .page-wrapper{
      margin-left: 210px;
      width: calc(100% - 210px);
    }
    .sidebar .sidebar-body .nav{
      padding: 25px 15px 50px 15px;
    }
    .sidebar .sidebar-body .nav .nav-item .nav-link .link-arrow{
      margin-left: 5px;
    }
    .sidebar .sidebar-header{
      width: 210px;
    }
    .navbar{
      left: 210px;
      width: calc(100% - 210px);
      height: 40px;
    }
    .sidebar-brand{
      display: contents;
    }
    .sidebar .sidebar-header{
      height: 40px;
    }
    .sidebar .sidebar-body{
      max-height: calc(100% - 40px);
    }
    .main-wrapper .page-wrapper .page-content{
      margin-top: 40px;
      padding: 15px 15px;
    }
  </style>
  <!-- common css -->
  <!-- end common css -->

  @stack('style')
</head>
<body data-base-url="{{url('/')}}">

  <script src="{{ asset('assets/js/spinner.js') }}"></script>

  <div class="main-wrapper" id="app">
    @include('backoffice.layout.sidebar')
    <div class="page-wrapper" style="background: #f1f1f1!important;">
      @include('backoffice.layout.header')
      <div class="page-content">
        @yield('content')
      </div>
      @include('backoffice.layout.footer')
    </div>
  </div>

    <!-- base js -->

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('assets/plugins/vue/vue.js') }}"></script>
    <script src="{{ asset('assets/plugins/axios/axios.js') }}"></script>
    <script src="{{ asset('assets/plugins/js-cookie/js.cookie.min.js') }}"></script>
    <script src="{{ asset('js/api.js') }}"></script>
    <script src="{{ asset('assets/plugins/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/summernote/summernote.min.js') }}"></script>


    <script type="text/javascript">
    // Vue.use( CKEditor );
      var eiApi = new eiAPI('{{url('')}}','{{url('api')}}')
      eiApi.checkJwt().then(response=>{
        // console.log(response);
        if(response==false){
          setTimeout(()=>{
            window.location.href="{{url('/login')}}";

          },1000);
        }
      })
      
    function formatMoney(num,sep){
        if(!sep){
            sep=',';
        }
        if(isNaN(parseFloat(num)) || typeof parseFloat(num)=='undefined'){
            return num;
        }
        // console.log(num,parseInt(num));
        // return;
        num=num.toString().replace(/,/g,'');
        num=parseFloat(num).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1'+sep);
        // console.log(num);
        return num
    }
    function initSummernote(selector,data,call){
      $(selector).summernote({
        height: 300,
        callbacks:{
          onInit:function(){
            $(this).summernote("code",data);
          },
          onChange:function(contents,$editable){
            call(contents);
          },
          onKeyup:function(e){
            call($(this).summernote('code'));
          },
          onBlur:function(){
            // $(this).summernote('code')
            
          }  
        }
      });
    }
      function initEditor(selector,callback,oninit=null){
        tinymce.init({
          selector: selector,
          height: 500,
          theme: 'silver',
          setup: (editor)=> {
            editor.on('init', (e)=> {
              // console.log('element change')
                if(oninit){
                  oninit();
                }
            });
            editor.on('input', (e)=> {
              // console.log('element change')
                callback(editor.getContent());
            });
            editor.on('NodeChange', (e)=> {
              // console.log('Node change')
                callback(editor.getContent());
            });
          },
          plugins: [
            'paste advlist autolink lists link image charmap hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
          ],
          toolbar1: 'pastetext pasteword selectall code | undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image |forecolor backcolor',
          theme_advanced_buttons3_add : "",
          image_advtab: false,
          content_css: [],
          image_title: true,
          automatic_uploads: true,
          file_picker_types: 'image',
          file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function () {
              var file = this.files[0];

              var reader = new FileReader();
              reader.onload = function () {
                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);
                cb(blobInfo.blobUri(), { title: file.name });
              };
              reader.readAsDataURL(file);
            };

            input.click();
          },
          content_style: 'body {  font-size:14px }'

        });
    }
    
    </script>
    <!-- end base js -->

    <!-- plugin js -->
    @stack('plugin-scripts')
    <!-- end plugin js -->

    <!-- common js -->
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <!-- end common js -->

    @stack('scripts')
    <script type="text/javascript">
      async function get_update(){
        await eiApi.post('admin/get_update')
          .then(response=>{
            if(response.data.status!=1){
              return
            }
            $(".wa_status").html(response.data.result.wa_status);
            $(".wa_qr").attr('src',response.data.result.wa_qr);
          })
      }
      get_update();
      setInterval(  ()=>{

        get_update()

      },5000)
        

      
    </script>
</body>
</html>