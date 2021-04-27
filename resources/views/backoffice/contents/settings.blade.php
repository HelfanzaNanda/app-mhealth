 <div class="card">
    <div class="card-body">

      <div>
        <div class="row mb-1" >
          <div class="col-3">Title</div>
          <div class="col-3">
            <input type="text" v-model="data.title" class="form-control form-control-sm" placeholder="Ethnic India">
            
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">URL</div>
          <div class="col-3">
            <input type="text" v-model="data.url" class="form-control form-control-sm" placeholder="Website url (ex. https://...)">
            
          </div>
        </div>

        <div class="row mb-1" >
          <div class="col-3">Site description</div>
          <div class="col-6">
            <textarea v-model="data.description" class="form-control form-control-sm" placeholder="Ethnic India is.."></textarea>
          </div>
        </div>

        <div class="row mb-1" >
          <div class="col-3">Whatsapp Query Product</div>
          <div class="col-6">
            <input type="text" v-model="data.wa_query_product" class="form-control form-control-sm" placeholder="Hello, im insterted with this product">
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">Whatsapp Query Contact</div>
          <div class="col-6">
            <input type="text" v-model="data.wa_query_contact" class="form-control form-control-sm" placeholder="Hello">
          </div>
        </div>
        <hr/>

        <div class="row mb-1" >
          <div class="col-3">Address</div>
          <div class="col-3">
            <textarea v-model="data.address" class="form-control form-control-sm" placeholder="Company address">
            </textarea>
          </div>
        </div>

        <div class="row mb-1" >
          <div class="col-3">Return Address</div>
          <div class="col-3">
            <textarea v-model="data.return_address" class="form-control form-control-sm" placeholder="Shipping return address">
            </textarea>
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">Return Pincode</div>
          <div class="col-3">
            <input v-model="data.return_pincode" class="form-control form-control-sm" placeholder="Pincode">
          </div>
        </div>
        
        <hr>
        <div class="row mb-1" >
          <div class="col-3">Phone</div>
          <div class="col-3">
            <input type="text" v-model="data.phone" class="form-control form-control-sm" placeholder="(+6 xxxxx xxxxx)">
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">Email</div>
          <div class="col-3">
            <input type="text" v-model="data.email" class="form-control form-control-sm" placeholder="(xxxxxx@mail.com)">
          </div>
        </div>
        <hr/>
        <div class="row mb-1" >
          <div class="col-3">Facebook</div>
          <div class="col-6">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">https://fb.com/</span>
              </div>
              <input type="text" v-model="data.facebook" class="form-control form-control-sm" placeholder="Social media username">
            </div>
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">Twitter</div>
          <div class="col-6">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">https://twitter.com/</span>
              </div>
              <input type="text" v-model="data.twitter" class="form-control form-control-sm" placeholder="Social media username">
            </div>
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">Instagram</div>
          <div class="col-6">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">https://instgaram.com/</span>
              </div>
              <input type="text" v-model="data.instagram" class="form-control form-control-sm" placeholder="Social media username">
            </div>
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">Youtube Channel Link</div>
          <div class="col-6">
            <input type="text" v-model="data.youtube" class="form-control form-control-sm" placeholder="Yotube link (ex.https://)">
          </div>
        </div>
        <hr/>

        <div class="row mb-1" >
          <div class="col-3">Whatsapp Number</div>
          <div class="col-3">
            <input type="text" v-model="data.whatsapp" class="form-control form-control-sm" placeholder="(+6 xxxxx xxxxx)">
          </div>
        </div>
      <div >
        <button class="btn btn-sm btn-primary" @click="save_content_batch()" >Save</button>
      </div>

    </div>
  </div>