@extends('backoffice.layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div id="content-page">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>

      <h4 class="mb-3 mb-md-0">Settings</h4>
    </div>
  </div>
  <div class="card">
    <div class="card-body">

      <!-- LOGIN INCENTIVE -->

      <div class="row mb-1">
        <div class="col-3">Login Incentive</div>
        <div class="col-9">
          <input type="checkbox" v-model="formData.login_incentive" value="=1"> Enable
        </div>
      </div>
      <div v-if="formData.login_incentive">
        <div class="row mb-1" >
          <div class="col-3">Coupon Code</div>
          <div class="col-3">
            <input type="text" v-model="formData.login_coupon_code" class="form-control form-control-sm">
          </div>
        </div>
        <hr/>
      </div>
      <!-- FIRST ORDER INCENTIVE -->

      <div class="row mb-1">
        <div class="col-3">First Order Incentive</div>
        <div class="col-9">
          <input type="checkbox" v-model="formData.first_order_incentive" value="=1"> Enable
        </div>
      </div>

      <div v-if="formData.first_order_incentive">
        <div class="row mb-1" >
          <div class="col-3">Coupon Code</div>
          <div class="col-3">
            <input type="text" v-model="formData.first_order_coupon_code" class="form-control form-control-sm">
          </div>
        </div>
        <hr/>
      </div>
      

      <div >
        <button class="btn btn-sm btn-primary" @click="save_content()" >Save</button>
      </div>

    </div>
  </div>


</div>

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
      el:'#content-page',
      data:{
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
          login_incentive:0,
          login_coupon_code:'',
          first_order_coupon_code:'',
        },
        mention_product:{
          id:0
        },
        listBanner:[],
        btn_disabled:{
          faq:true,
          contact:true,
          privacy:true,
          term:true,
          about:true,
        }
      },
      watch:{
        data(v){
          
        }
      },
      mounted(){
        // this.list_banner();
       
        this.get_content();
      },
      methods:{
        async get_content(){
          await eiApi.post('content/get')
          .then(response=>{
            if(response.data.status==1){
              this.formData=response.data.result;
            }
          })
          .catch(error=>{
            console.log(error)
          })
        },
        async save_content(){
          this.isLoading=true;
          await eiApi.post('content/save_batch',{items:this.formData})
          .then(response=>{
            if(response.data.status==1){
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
          this.isLoading=false;

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
        // async UploadBanner(){
        //   this.formBanner.isUploading=true;
        //   if(this.formBanner.id){
        //     await eiApi.post('content/banner/save',this.formBanner)
        //       .then(response=>{
        //         if(response.data.status!=1){
        //           Swal.fire({
        //             type:'warning',
        //             msg:response.data.msg,
        //             showConfirmButton:false,
        //             timer:2000,
        //           })
        //           return;
        //         }
        //         this.list_banner();
        //         $("#upload-banner-modal").modal("hide")
        //       })
        //       .catch(error=>{
        //         console.log(error)
        //       })
        //   }else{
        //     var formData = new FormData();
        //     var file = $("#uploadbanner")[0].files[0];
        //     formData.append('file',file);
        //     formData.append('link',this.formBanner.link);
        //     await eiApi.post('content/banner/upload',formData)
        //       .then(response=>{
        //         if(response.data.status!=1){
        //           Swal.fire({
        //             type:'warning',
        //             msg:response.data.msg,
        //             showConfirmButton:false,
        //             timer:2000,
        //           })
        //           return
        //         }
        //         this.list_banner();
        //         $("#upload-banner-modal").modal("hide")
        //       })
        //       .catch(error=>{
        //         console.log(error)
        //       })
        //   }
        //   this.formBanner.isUploading=false;
        // },

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