 <div class="card">
    <div class="card-body">

      <div>
        <h5>Searchbox</h5>
        <div class="row mb-1" >
          <div class="col-3">Placeholder</div>
          <div class="col-4">
            <input type="text" v-model="data.search_placeholder" class="form-control form-control-sm" placeholder="what are you adding to wardrobe today">
          </div>
        </div>

        <div class="row mb-1" >
          <div class="col-3">Trending Keywords (split with comma)</div>
          <div class="col-3">
            <input type="text" v-model="data.trending_keywords" class="form-control form-control-sm" placeholder="Kurti, mens kurti">
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">Popular Product Count</div>
          <div class="col-3">
            <input type="number" min="0" max="10" v-model="data.popular_product_count" class="form-control form-control-sm" placeholder="0">
          </div>
        </div>
        <hr/>

      <h5>Section</h5>
      <div class="row mb-1">
        <div class="col-3">Show Ourlook ?</div>
        <div class="col-3">


          <select class="form-control" v-model="data.show_ourlook">
            <option value="1">Enable</option>
            <option value="0">Disable</option>
          </select>
        </div>
      </div>
      <hr/>
      <h5>Search Filter</h5>
      <div class="row mb-1" >
        <div class="col-3">Price Filter (Start from)</div>
        <div class="col-4">
          <input type="text" v-model="data.price_filter" class="form-control form-control-sm" placeholder="ex. 1000,5000,10000,20000">
          <p>Split by comma (,).</p>
        </div>
      </div>
<hr/>
        <h5>Home Page</h5>

        <div class="row mb-1" >
          <div class="col-3">Push Product by</div>
          <div class="col-3">
            <select v-model="data.push_product_by" class="form-control form-control-sm">
              <option value="random">Random Product</option>
              <option value="popular">Popular (by views)</option>
              <option value="trending">Trending Product (by rating)</option>
            </select>
          </div>
        </div>
      </div>
<!-- LOGIN INCENTIVE -->
      <h5>Popup</h5>
      <div class="row mb-1">
        <div class="col-3">Login Incentive</div>
        <div class="col-3">

          <select class="form-control" v-model="data.login_incentive">
            <option value="1">Enable</option>
            <option value="0">Disable</option>
          </select>
        </div>
      </div>
      <div v-if="data.login_incentive">
        <div class="row mb-1" >
          <div class="col-3">Coupon Code</div>
          <div class="col-3">
            <input type="text" v-model="data.login_coupon_code" class="form-control form-control-sm">
          </div>
        </div>
        <hr/>
      </div>
      <!-- FIRST ORDER INCENTIVE -->

      <div class="row mb-1">
        <div class="col-3">First Order Incentive</div>
        <div class="col-3">
          <select class="form-control" v-model="data.first_order_incentive">
            <option value="1">Enable</option>
            <option value="0">Disable</option>
          </select>
        </div>
      </div>

      <div v-if="data.first_order_incentive">
        <div class="row mb-1" >
          <div class="col-3">Coupon Code</div>
          <div class="col-3">
            <input type="text" v-model="data.first_order_coupon_code" class="form-control form-control-sm">
          </div>
        </div>
        <hr/>
      </div>

      <div>
        <div class="row mb-1" >
          <div class="col-3">Custom Script</div>
          <div class="col-9">
            <textarea v-model="data.custom_script" class="form-control form-control-sm" rows="20">
            </textarea>
          </div>
        </div>
        <hr/>
      </div>
      <div >
        <button class="btn btn-sm btn-primary" @click="save_content_batch()" >Save</button>
      </div>

    </div>
  </div>