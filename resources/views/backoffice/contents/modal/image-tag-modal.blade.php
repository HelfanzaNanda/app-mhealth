<div class="modal" tabindex="-1" role="dialog" id="image-tag-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Image popper</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex">
          <div style="width: 320px;height:320px;position: relative;" @click="FrameClicked($event)">
            <img :src="'{{config('app.API_URL')}}/'+image" style="width: 100%;height: 100%;object-fit: cover;">
            <span style="position: absolute;border: 2px solid white;color: white;padding: 3px 7px;line-height: 1;font-size: 14px;border-radius: 5px;background-color: #8e8e8e38" :style="{'top':item.top,'left':item.left}" v-for="item in popper">
                @{{item.caption}}
            </span>
          </div>
          <div class="flex-grow p-1">
            <button class="btn btn-sm btn-primary" @click="AddNew()">Add new popper</button>
            <table class="table table-sm">
              <tr v-for="(item,idx) in popper">
                <td><input type="text" v-model="item.caption" class="form-control form-control-sm" placeholder="Insert text" /></td>
                <td><button class="btn btn-sm btn-danger" @click="RemovePopper(idx)">Remove</button></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" @click="SavePopper()">Save</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
  <script type="text/javascript">
    var imageTagModal = new Vue({
      el:'#image-tag-modal',
      data:{
        popper:[],
        data:{},
        tmpColorHex:'',
        addNew:false,
        poppername:'',
        callback:null,
        image:'',
      },
      computed:{
        
      },
      mounted(){
      },
      methods:{
        FrameClicked(e){
          if(this.addNew){
            var topPos=e.offsetY/e.target.offsetHeight*100;
            var leftPos=e.offsetX/e.target.offsetWidth*100;
            this.popper.push({caption:'',top:(topPos+'%'),left:(leftPos+'%')});
            this.addNew=false;
          }
        },
        RemovePopper(idx){
          this.popper.splice(idx,1);
        },
        AddNew(){
          this.addNew=true;
          Swal.fire({
            text:"Click position on the image",
            timer:1000,
            showConfirmButton:false
          })
        },
        open(data,image,poppername){
          this.data=data;
          this.image=image;
          this.poppername=poppername
          // console.log(data);
          try{
            this.popper=JSON.parse(data[this.poppername])??[];
          }catch($e){
            this.popper=[];
          }
          // console.log(data);
          $("#image-tag-modal").modal("show");
        },
        close(){
          if(this.callback) this.callback(this.popper);
          $("#image-tag-modal").modal("hide");
        },
        async SavePopper(){
          this.data[this.poppername]=JSON.stringify(this.popper);
          this.close();
        },
      }
    })
  </script>
@endpush