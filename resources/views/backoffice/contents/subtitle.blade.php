 <div class="card">
    <div class="card-body">

      <div>
        <h5 class="mb-1">Home & Global</h5>
        <div class="row mb-1" >
          <div class="col-3">Section title: Category</div>
          <div class="col-3">
            <input type="text" v-model="data.subtitle_category" class="form-control form-control-sm" placeholder="Browse product">
            
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">Section title: Collection</div>
          <div class="col-3">
            <input type="text" v-model="data.subtitle_collection" class="form-control form-control-sm" placeholder="Browse product">
            
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">Section title: Fabrics</div>
          <div class="col-3">
            <input type="text" v-model="data.subtitle_fabrics" class="form-control form-control-sm" placeholder="Browse product">
            
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">Section title: Shop By Price</div>
          <div class="col-3">
            <input type="text" v-model="data.subtitle_shop_by_price" class="form-control form-control-sm" placeholder="Browse product">
            
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">Section title: Our Look</div>
          <div class="col-3">
            <input type="text" v-model="data.subtitle_our_look" class="form-control form-control-sm" placeholder="Browse product">
            
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">Section title: Recomended For You</div>
          <div class="col-3">
            <input type="text" v-model="data.subtitle_recomended_for_you" class="form-control form-control-sm" placeholder="Browse product">
            
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">Section title: Subscribe</div>
          <div class="col-3">
            <input type="text" v-model="data.subtitle_subscribe" class="form-control form-control-sm" placeholder="Browse product">
            
          </div>
        </div>
        <hr/>
        <h5 class="mb-1">Product</h5>
        <div class="row mb-1" >
          <div class="col-3">Section: Style Like Related Product</div>
          <div class="col-3">
            <input type="text" v-model="data.subtitle_style_like" class="form-control form-control-sm" placeholder="Browse product">
            
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">Section: How To Style This Product</div>
          <div class="col-3">
            <input type="text" v-model="data.subtitle_how_to_style" class="form-control form-control-sm" placeholder="Browse product">
            
          </div>
        </div>
        <hr/>
        <div class="row mb-1" >
          <div class="col-3">Page: Lookbook</div>
          <div class="col-3">
            <input type="text" v-model="data.subtitle_lookbook" class="form-control form-control-sm" placeholder="Browse product">
            
          </div>
        </div>

      <div >
        <button class="btn btn-sm btn-primary" @click="save_content_batch()" >Save</button>
      </div>

    </div>
  </div>