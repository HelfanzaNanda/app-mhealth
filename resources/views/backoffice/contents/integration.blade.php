 <div class="card">
    <div class="card-body">

      <div>

        <h5 class="mb-1">Delhivery</h5>
        <div class="row mb-1" >
          <div class="col-3">API KEY</div>
          <div class="col-6">
            <input type="text" v-model="data.delhivery_key" class="form-control form-control-sm" >
          </div>
        </div>
        <hr/>
        <h5 class="mb-1">Razorpay</h5>
        <div class="row mb-1" >
          <div class="col-3">API KEY</div>
          <div class="col-6">
            <input type="text" v-model="data.razor_key" class="form-control form-control-sm" >
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">API Secret</div>
          <div class="col-6">
            <input type="text" v-model="data.razor_secret" class="form-control form-control-sm" >
          </div>
        </div>
        <hr/>
        <h5 class="mb-1">Push Notification</h5>
        <div class="row mb-1" >
          <div class="col-3">OneSignal APP ID</div>
          <div class="col-6">
            <input type="text" v-model="data.onesignal_id" class="form-control form-control-sm" >
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">OneSignal Safari WEB ID</div>
          <div class="col-6">
            <input type="text" v-model="data.onesignal_safari_id" class="form-control form-control-sm" >
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">OneSignal API Key</div>
          <div class="col-6">
            <input type="text" v-model="data.onesignal_key" class="form-control form-control-sm" >
          </div>
        </div>
        <hr/>
        <h5 class="mb-1">Mailchimp</h5>
        <div class="row mb-1" >
          <div class="col-3">Email Account</div>
          <div class="col-6">
            <input type="text" v-model="data.mailchimp_email" class="form-control form-control-sm" placeholder="noreply@WhatsappGateway.co">
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">Mailchimp Key</div>
          <div class="col-6">
            <input type="text" v-model="data.mailchimp_key" class="form-control form-control-sm" >
          </div>
        </div>
        <hr/>
        <h5 class="mb-1">Facebook</h5>
        <div class="row mb-1" >
          <div class="col-3">Facbook APP ID</div>
          <div class="col-6">
            <input type="text" v-model="data.fb_id" class="form-control form-control-sm" >
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">Facebook APP Secret</div>
          <div class="col-6">
            <input type="text" v-model="data.fb_secret" class="form-control form-control-sm" >
          </div>
        </div>
        <hr/>
        <h5 class="mb-1">Google</h5>
        <div class="row mb-1" >
          <div class="col-3">Client ID</div>
          <div class="col-6">
            <input type="text" v-model="data.google_id" class="form-control form-control-sm" >
          </div>
        </div>
        <div class="row mb-1" >
          <div class="col-3">Client Secret</div>
          <div class="col-6">
            <input type="text" v-model="data.google_secret" class="form-control form-control-sm" >
          </div>
        </div>
        <hr/>
        <h5 class="mb-1">Google Analytic</h5>
        <div class="row mb-1" >
          <div class="col-3">Analytic Tag</div>
          <div class="col-6">
            <input type="text" v-model="data.analytic_tag" class="form-control form-control-sm" >
          </div>
        </div>
        <hr/>
      </div>

      <div >
        <button class="btn btn-sm btn-primary" @click="save_content_batch()" >Save</button>
      </div>

    </div>
  </div>