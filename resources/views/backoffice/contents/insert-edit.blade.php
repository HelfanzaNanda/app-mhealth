  <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>

      <h4 class="mb-3 mb-md-0"><a href="javascript:;" @click="Back(mode)"><i data-feather="chevron-left"></i></a> Blogs - @{{mode}}</h4>
      <!-- <template v-if="mode=='edit'">@{{data.name}}</template> -->
    </div>
  </div>
  <div v-if="isLoading">
    <div class="card">
      <div class="card-body text-center">
          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        
      </div>
    </div>
  </div>
  <div v-else>  
    <div class="row">
      <div class="col-md-8"><input class="form-control" v-model="data.title" @input ="TitleChange()" placeholder="Post title" /></div>
      <div class="col-md-2">
        <button class="btn btn-block btn-outline-primary" @click="Save()">Save <span v-if="!data.is_active">as Draft</span></button>
      </div>
      <div class="col-md-2" v-if="!data.is_active">
        <button class="btn btn-block btn-primary" @click="Publish()">Publish</button>
      </div>
      <div class="col-md-12 mt-2">
        <div class="form-inline">
          <span class="mt-2">URL : <strong>{{url('blog')}}/</strong></span>
          <input class="form-control form-control-sm"  placeholder="Slug" v-model="data.slug"/>         
        </div>
      </div>
    </div>
    <div class="row mt-2">
      <div class="col-md-9">
        <div class="card">
          <div class="card-body">
            <div>
              <textarea class="form-control" name="tinymce" id="editor" rows="10" ></textarea>
            </div>
            
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">Mention Product</h5>
          </div>
          <div class="card-body">
            <table class="table table-sm table-hovered table-striped">
              <tr v-for="product in data.mention_product">
                <td>@{{product.name}}</td>
                <td>
                  <button class="btn btn-sm">
                    <i data-feather="x"> Remove</i>
                  </button>
                </td>
              </tr>
              <tr>
                <td>
                  <select v-model="mention_product.id" class="form-control form-control-sm">
                    <option></option>
                  </select>
                </td>
                <td>
                  <button class="btn btn-sm btn-primary">
                    <i data-feather="plus" style="width: 14px;height: 14px;"></i> Insert
                  </button>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card mb-2">
          <div class="card-header">
            <h5 class="card-title mb-0">STATUS</h5>
          </div>
          <div class="card-body">
            <div>
              <select class="form-control-sm form-control" v-model="data.is_active">
                <option value="1">Published</option>
                <option value="0">Draft</option>
              </select>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">Thumbail</h5>
          </div>
          <div class="card-body">
            <input hidden type="file" onclick="this.value=null" @input="ImageUpload()" accept="image/*" id="uploadimage">

              <div style="height: 100px;" v-if="!isUploading">
                
                <img :src="data.thumbnail" style="width: 100%;height:100%;object-fit: cover;">
                
              </div>
              <div class="text-center" style="height: 100px;" v-else>
                <div style="margin-top:50%;transform: translateY(-50%);">
                  <span class="spinner-border" role="status" aria-hidden="true"></span>
                </div>
              </div>
              
              <div class="text-center" style="cursor: pointer;" onclick="$('#uploadimage').click()">
                <div class=" bg-primary text-white py-1">
                <i data-feather="upload" style="width: 14px;height: 14px;" ></i>      
                </div>        
              </div>

          </div>
        </div>
      </div> 
    </div>
  </div>

@push('scripts')
  <script type="text/javascript">

  </script>
  @endpush