@extends('backoffice.layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div id="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>

      <h4 class="mb-3 mb-md-0">Site Contents</h4>
    </div>
  </div>

  @if($loc=='banner')
    @include('backoffice.contents.banner')
  @endif
  @if($loc=='faq')
    @include('backoffice.contents.faq')
  @endif
  @if($loc=='contact')
    @include('backoffice.contents.contact')
  @endif
  @if($loc=='about')
    @include('backoffice.contents.about')
  @endif
  @if($loc=='term')
    @include('backoffice.contents.term')
  @endif
  @if($loc=='privacy')
    @include('backoffice.contents.privacy')
  @endif 
  @if($loc=='settings')
    @include('backoffice.contents.settings')
  @endif
  @if($loc=='integration')
    @include('backoffice.contents.integration')
  @endif
  @if($loc=='subtitle')
    @include('backoffice.contents.subtitle')
  @endif
  @if($loc=='main')
    @include('backoffice.contents.main')
  @endif
  @if($loc=='custom_section')
    @include('backoffice.contents.custom_section')
  @endif
  @if($loc=='email-template')
    @if($loc2=='activation')
      @include('backoffice.contents.email-template.activation')
    @elseif($loc2=='welcome')
      @include('backoffice.contents.email-template.welcome')
    @elseif($loc2=='password-recovery')
      @include('backoffice.contents.email-template.password-recovery')
    @elseif($loc2=='order-cancel')
      @include('backoffice.contents.email-template.order-cancel')
    @elseif($loc2=='order-completed')
      @include('backoffice.contents.email-template.order-completed')
    @elseif($loc2=='order-placed')
      @include('backoffice.contents.email-template.order-placed')
    @elseif($loc2=='order-packed')
      @include('backoffice.contents.email-template.order-packed')
    @elseif($loc2=='order-delivery')
      @include('backoffice.contents.email-template.order-delivery')
    @elseif($loc2=='notification')
      @include('backoffice.contents.email-template.notification')
    @endif

  @endif


</div>
@include('backoffice.contents.modal.image-tag-modal')
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/progressbar-js/progressbar.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
@endpush

@push('scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
  <script type="text/javascript">
    
    var app = new Vue({
      el:'#page-content',
      data:{
        loc:'{{$loc}}',
        mode:'list',
        isLoading:true,
        isSaving:false,
        isUploading:false,
        listData:[],
        page:1,
        totalpage:10,
        limit:10,
        total:1000,
        sort:'title',
        order:'asc',
        category:0,
        data:{},
        formData:{

        },
        formBanner:{
          isLoading:false,
          link:'',
          type:'desktop',
          id:null,
        },
        mention_product:{
          id:0
        },
        listBanner:[],
        btn_disabled:{
          tmp_welcome:true,
          tmp_activation:true,
          tmp_password_recovery:true,
          tmp_order_placed:true,
          tmp_order_packed:true,
          tmp_order_delivery:true,
          tmp_order_completed:true,
          tmp_order_cancel:true,
          tmp_notification:true,
        }
      },
      watch:{
        data(v){
          console.log(v);

          try{tinymce.get("tmp_welcome-editor").setContent(this.data['tmp_welcome']);}catch($e){}
          try{tinymce.get("tmp_activation-editor").setContent(this.data['tmp_activation']);}catch($e){}
          try{tinymce.get("tmp_password_recovery-editor").setContent(this.data['tmp_password_recovery']);}catch($e){}
          try{tinymce.get("tmp_order_placed-editor").setContent(this.data['tmp_order_placed']);}catch($e){}
          try{tinymce.get("tmp_order_packed-editor").setContent(this.data['tmp_order_packed']);}catch($e){}
          try{tinymce.get("tmp_order_delivery-editor").setContent(this.data['tmp_order_delivery']);}catch($e){}
          try{tinymce.get("tmp_order_completed-editor").setContent(this.data['tmp_order_completed']);}catch($e){}
          try{tinymce.get("tmp_order_cancel-editor").setContent(this.data['tmp_order_cancel']);}catch($e){}
          try{tinymce.get("tmp_notification-editor").setContent(this.data['tmp_notification']);}catch($e){}
        }
      },
      mounted(){
        this.list_banner();
        (async()=>{
          await this.get_content();

          initEditor('#tmp_welcome-editor',(text)=>{
            this.btn_disabled.tmp_welcome=false;
            this.data['tmp_welcome']=text;
          },()=>{
          try{tinymce.get("tmp_welcome-editor").setContent(this.data['tmp_welcome']);}catch($e){}
            
          });

          
          initEditor('#tmp_activation-editor',(text)=>{
            this.btn_disabled.tmp_activation=false;
            this.data['tmp_activation']=text;
          },()=>{
          try{tinymce.get("tmp_activation-editor").setContent(this.data['tmp_activation']);}catch($e){}
            
          });

          
          initEditor('#tmp_password_recovery-editor',(text)=>{
            this.btn_disabled.tmp_password_recovery=false;
            this.data['tmp_password_recovery']=text;
          },()=>{
          try{tinymce.get("tmp_password_recovery-editor").setContent(this.data['tmp_password_recovery']);}catch($e){}
            
          });

          
          initEditor('#tmp_password_recovery-editor',(text)=>{
            this.btn_disabled.tmp_password_recovery=false;
            this.data['tmp_welcome']=text;
          },()=>{
          try{tinymce.get("tmp_password_recovery-editor").setContent(this.data['tmp_password_recovery']);}catch($e){}
            
          });

          
          initEditor('#tmp_order_placed-editor',(text)=>{
            this.btn_disabled.tmp_order_placed=false;
            this.data['tmp_order_placed']=text;
          },()=>{
          try{tinymce.get("tmp_order_placed-editor").setContent(this.data['tmp_order_placed']);}catch($e){}
            
          });

          
          initEditor('#tmp_order_packed-editor',(text)=>{
            this.btn_disabled.tmp_order_packed=false;
            this.data['tmp_order_packed']=text;
          },()=>{
          try{tinymce.get("tmp_order_packed-editor").setContent(this.data['tmp_order_packed']);}catch($e){}
            
          });

          
          initEditor('#tmp_order_delivery-editor',(text)=>{
            this.btn_disabled.tmp_order_delivery=false;
            this.data['tmp_order_delivery']=text;
          },()=>{
          try{tinymce.get("tmp_order_delivery-editor").setContent(this.data['tmp_order_delivery']);}catch($e){}
            
          });
          
          initEditor('#tmp_order_completed-editor',(text)=>{
            this.btn_disabled.tmp_order_completed=false;
            this.data['tmp_order_completed']=text;
          },()=>{
          try{tinymce.get("tmp_order_completed-editor").setContent(this.data['tmp_order_completed']);}catch($e){}
            
          });
          
          initEditor('#tmp_order_cancel-editor',(text)=>{
            this.btn_disabled.tmp_order_cancel=false;
            this.data['tmp_order_cancel']=text;
          },()=>{
          try{tinymce.get("tmp_order_cancel-editor").setContent(this.data['tmp_order_cancel']);}catch($e){}
            
          });

          initEditor('#tmp_notification-editor',(text)=>{
            this.btn_disabled.tmp_notification=false;
            this.data['tmp_notification']=text;
          },()=>{
          try{tinymce.get("tmp_notification-editor").setContent(this.data['tmp_notification']);}catch($e){}
            
          });


        })();
        
      },
      methods:{
        OpenImageTag(data,image,popper){
          imageTagModal.open(data,image,popper);
          imageTagModal.callback=(popperdata)=>{
            this.data[popper]=JSON.stringify(popperdata);
            this.save_content_batch();
          }
        },
        async list_banner(){
          await eiApi.post('content/banner/list')
          .then(response=>{
            if(response.data.status==1){
              this.listBanner=response.data.result;
            }

          })
          .catch(error=>{
            console.log(error)
          })
        },
        async get_content(){
          await eiApi.post('content/get')
          .then(response=>{
            if(response.data.status==1){
              this.data=response.data.result;
            }

          })
          .catch(error=>{
            console.log(error)
          })
        },

        async save_content_batch(){
          var key = {
            integration:['analytic_tag','google_secret','google_id','fb_secret','fb_id','mailchimp_key','mailchimp_email','onesignal_key','onesignal_id','razor_secret','razor_key','delhivery_key','onesignal_safari_id'],
            settings:['address','return_address','return_pincode','wa_query_product','wa_query_contact','title','url','description','phone','email','facebook','twitter','instagram','youtube','whatsapp'],
            main:['show_ourlook','search_placeholder','trending_keywords','price_filter','popular_product_count','push_product_by','login_incentive','login_coupon_code','first_order_incentive','first_order_coupon_code','custom_script'],
            custom_section:['custom_section_title','show_fabric_section',
              ,'fabric_section_image1_link','fabric_section_image1_button','fabric_section_image1_text','fabric_section_image1_title','fabric_section_image1_popper',
              ,'fabric_section_image2_link','fabric_section_image2_button','fabric_section_image2_text','fabric_section_image2_title','fabric_section_image2_popper',
              ,'fabric_section_image3_link','fabric_section_image3_button','fabric_section_image3_text','fabric_section_image3_title','fabric_section_image3_popper',],
            subtitle:['subtitle_category','subtitle_collection','subtitle_fabrics','subtitle_shop_by_price','subtitle_our_look','subtitle_recomended_for_you','subtitle_subscribe','subtitle_style_like','subtitle_how_to_style','subtitle_lookbook']
          };
          var key_list = key[this.loc];
          if(!key[this.loc]){
            return;
          }
          this.isLoading=true;
          await eiApi.post('content/save_batch',{items:this.data,inclusive:key_list})
          .then(response=>{
            if(response.data.status==1){
              Swal.fire({
                icon:'success',
                text:'Updated',
                showConfirmButton:false,
                timer:1000,
              })
              this.get_content();
              return;
            }
            Swal.fire({
                icon:'warning',
                text: response.data.msg,
                showConfirmButton:false,
                timer:1000,
              })
          })
          .catch(error=>{
            console.log(error)
          })
          this.isLoading=false;

        },
        async save_content(name,value){
          await eiApi.post('content/save',{name:name,value:value})
          .then(response=>{
            if(response.data.status==1){
              this.btn_disabled[name]=true;
              Swal.fire({
                icon:'success',
                text:'Updated',
                showConfirmButton:false,
                timer:1000,
              })
              return;
            }
            Swal.fire({
                icon:'warning',
                text: response.data.msg,
                showConfirmButton:false,
                timer:1000,
              })
          })
          .catch(error=>{
            console.log(error)
          })
        },

//---BANNER START
        async openBannerModal(){
          $("#uploadbanner").val(null);
          this.formBanner.link='';
          this.formBanner.id=null;
          $("#upload-banner-modal").modal("show");
        },
        EditBanner(row){
          this.formBanner.id=row.id;
          this.formBanner.link=row.link;
          this.formBanner.type=row.type;
          $("#upload-banner-modal").modal("show");
        },
        DeleteBanner(item){
          Swal.fire({
            icon:'question',
            text:`Are you sure want to delete this item (${item.link})?`,
            showCancelButton: true,
            confirmButtonText: 'Confirm'
          }).then(async (result) => {
            console.log(result);
            if (result.value) {
              this.isLoading=true;
                await eiApi.post('content/banner/delete',{id:item.id})
                  .then(response=>{
                    this.list_banner();
                  })
                  .catch(error=>{
                    console.log(error)
                  })
              this.isLoading=false;
            }
          })
          
        },
        async UploadBanner(){
          this.formBanner.isUploading=true;
          if(this.formBanner.id){
            await eiApi.post('content/banner/save',this.formBanner)
              .then(response=>{
                if(response.data.status!=1){
                  Swal.fire({
                    icon:'warning',
                    text:response.data.msg,
                    showConfirmButton:false,
                    timer:2000,
                  })
                  return;
                }
                this.list_banner();
                $("#upload-banner-modal").modal("hide")
              })
              .catch(error=>{
                console.log(error)
              })
          }else{
            var formData = new FormData();
            var file = $("#uploadbanner")[0].files[0];
            formData.append('file',file);
            formData.append('link',this.formBanner.link);
            formData.append('type',this.formBanner.type);
            await eiApi.post('content/banner/upload',formData)
              .then(response=>{
                if(response.data.status!=1){
                  Swal.fire({
                    type:'warning',
                    msg:response.data.msg,
                    showConfirmButton:false,
                    timer:2000,
                  })
                  return
                }
                this.list_banner();
                $("#upload-banner-modal").modal("hide")
              })
              .catch(error=>{
                console.log(error)
              })
          }
          this.formBanner.isUploading=false;
        },
//---BANNER END

        async get_list(){
          this.isLoading=true;
          this.listData=[];
          await eiApi.post('blog/list',{sort:this.sort,search:this.search,order:this.order,limit:this.limit,page:this.page})
            .then(response=>{
              if(response.data.status==1){
                this.listData = response.data.result;
                this.totalpage = response.data.totalpage;
                this.total = response.data.total;
              }
            })
            .catch(error=>{
              console.log(error)
            })
          this.isLoading=false;
        },
        async list_category(){
          // this.isLoading=true;
          this.listCategory=[];
          await eiApi.post('data/list_category')
            .then(response=>{
              if(response.data.status==1){
                this.listCategory = response.data.result;
              }
            })
            .catch(error=>{
              console.log(error)
            })
          // this.isLoading=false;
        },
        async get_data(id){
          this.isLoading=true;
          this.listData=[];
          await eiApi.post('blog/get',{id:id})
            .then(response=>{
              if(response.data.status==1){
                this.data=response.data.result;
              }
            })
            .catch(error=>{
              console.log(error)
            })
          this.isLoading=false;
        },
        async ImageChange($e,name){
          if(!$e.target.files[0]){
            Swal.fire({
                type:'warning',
                msg:"No file selected",
                showConfirmButton:false,
                timer:2000,
              })
              return
          }
          this.isLoading=true;
          var formData = new FormData();
          formData.append('file',$e.target.files[0])
          formData.append('name',name)
          await eiApi.post('content/upload',formData)
            .then(async (response)=>{
            if(response.data.status!=1){
              Swal.fire({
                type:'warning',
                msg:response.data.msg,
                showConfirmButton:false,
                timer:2000,
              })
              return
            }
            await this.save_content_batch();
          })
          .catch(error=>{
            console.log(error)
          });
          this.isLoading=false;

        
        },
        async RemoveImage(id,idx){
          await eiApi.post('blog/remove_image',{id:id})
            .then(response=>{
              if(response.data.status){
                this.data.images=this.data.images.slice((idx-1),1);

                Swal.fire({
                  type:'success',
                  text:'Image Removed',
                  timer:2000
                })
              }
            })
            .catch(error=>{
              console.log(error)
            })
        },
        Delete(item){
          Swal.fire({
            icon:'question',
            text:`Are you sure want to delete this item (${item.name})?`,
            showCancelButton: true,
            confirmButtonText: 'Confirm'
          }).then(async (result) => {
            console.log(result);
            if (result.value) {
              this.isLoading=true;
                await eiApi.post('category/delete',{id:item.id})
                  .then(response=>{
                    this.get_list();
                  })
                  .catch(error=>{
                    console.log(error)
                  })
                this.isLoading=false;
            }
          })
          
        },
        Insert(){
          this.list_category();
          this.data={
            id:null,
            mention_product:[],
          };
          this.mode='insert';
        },
        Edit(id){
          this.list_category();
          this.get_data(id);
          this.mode='edit';
        },
        Back(mode){
          this.get_list();
          this.mode='list';
        },
        TitleChange(){
          var name = this.data.title;
          var slug = name.toLowerCase().replace(/\s/g,'-').replace(/[^\w-]+/g,'');
          this.data.slug=slug;
        },
        async Save(){
          this.isSaving=true;
          this.data.body=tinymce.get("editor").getContent();

          await eiApi.post('blog/save',this.data)
          .then(response=>{
            if(response.data.status!=1){
              Swal.fire({
                icon:'warning',
                text:response.data.msg
              })
              return;
            }
            Swal.fire({
              icon:'success',
              text:'Saved!',
              showConfirmButton:false,
              timer:2000
            })
            this.get_data(response.data.id);
            this.get_list();
          })
          .catch(error=>{
            console.log(error)
          })
          this.isSaving=false;
        },
        async Publish(){
          this.data.is_active=1;
          await this.Save();
        }
      },
      updated(){
        $(()=> {
            'use strict';
            feather.replace();
              if($('.owl-auto-play').length) {
                $('.owl-auto-play').owlCarousel({
                  items:4,
                  loop:true,
                  margin:10,
                  autoplay:true,
                  autoplayTimeout:1000,
                  autoplayHoverPause:true,
                  responsive:{
                    0:{
                        items:2
                    },
                    600:{
                        items:3
                    },
                    1000:{
                        items:4
                    }
                }
                });
              }
            //Tinymce editor
            if ($("#editor").length) {
              tinymce.init({
                selector: '#editor',
                height: 400,
                theme: 'silver',
                setup: (editor)=> {
                  editor.on('init', (e)=> {
                    editor.setContent(this.data.body);
                  }).on('input', (e)=> {
                      this.data.body=editor.getContent();
                  });
                },
                plugins: [
                  'advlist autolink lists link image charmap hr anchor pagebreak',
                  'searchreplace wordcount visualblocks visualchars code fullscreen',
                ],
                toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image |forecolor backcolor',
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
              console.log(this.data.body);
              tinymce.get("editor").setContent(this.data.body);

            }
        });
      }
    })
  </script>
@endpush