<div class="card">
  <div class="card-body">
  	<div class="mb-3">
	    <h5 class="card-text">Welcome Email</h5>
	    <textarea class="form-control" name="tinymce" id="tmp_welcome-editor" rows="10" ></textarea>
		<div class="mt-2">
			<button class="btn btn-primary" :disabled="btn_disabled.tmp_welcome" @click="save_content('tmp_welcome',data['tmp_welcome'])">Save</button>
		</div>
		<hr/>
	</div>
  	<div class="mb-3">
	    <h5 class="card-text">Activation Email</h5>
	    <textarea class="form-control" name="tinymce" id="tmp_activation-editor" rows="10" ></textarea>
		<div class="mt-2">
			<button class="btn btn-primary" :disabled="btn_disabled.tmp_activation" @click="save_content('tmp_activation',data['tmp_activation'])">Save</button>
		</div>
		<hr/>
	</div>
  	<div class="mb-3">
	    <h5 class="card-text">Password Recovery Email</h5>
	    <textarea class="form-control" name="tinymce" id="tmp_password_recovery-editor" rows="10" ></textarea>
		<div class="mt-2">
			<button class="btn btn-primary" :disabled="btn_disabled.tmp_password_recovery" @click="save_content('tmp_password_recovery',data['tmp_password_recovery'])">Save</button>
		</div>
		<hr/>
	</div>
  	<div class="mb-3">
	    <h5 class="card-text">Order Placed Email</h5>
	    <textarea class="form-control" name="tinymce" id="tmp_order_placed-editor" rows="10" ></textarea>
		<div class="mt-2">
			<button class="btn btn-primary" :disabled="btn_disabled.tmp_order_placed" @click="save_content('tmp_order_placed',data['tmp_order_placed'])">Save</button>
		</div>
		<hr/>
	</div>
  	<div class="mb-3">
	    <h5 class="card-text">Order Packed Email</h5>
	    <textarea class="form-control" name="tinymce" id="tmp_order_packed-editor" rows="10" ></textarea>
		<div class="mt-2">
			<button class="btn btn-primary" :disabled="btn_disabled.tmp_order_packed" @click="save_content('tmp_order_packed',data['tmp_order_packed'])">Save</button>
		</div>
		<hr/>
	</div>
  	<div class="mb-3">
	    <h5 class="card-text">Order On The Way Email</h5>
	    <textarea class="form-control" name="tinymce" id="tmp_order_delivery-editor" rows="10" ></textarea>
		<div class="mt-2">
			<button class="btn btn-primary" :disabled="btn_disabled.tmp_order_delivery" @click="save_content('tmp_order_delivery',data['tmp_order_delivery'])">Save</button>
		</div>
		<hr/>
	</div>
  	<div class="mb-3">
	    <h5 class="card-text">Order Completed Email</h5>
	    <textarea class="form-control" name="tinymce" id="tmp_order_completed-editor" rows="10" ></textarea>
		<div class="mt-2">
			<button class="btn btn-primary" :disabled="btn_disabled.tmp_order_completed" @click="save_content('tmp_order_completed',data['tmp_order_completed'])">Save</button>
		</div>
		<hr/>
	</div>
  	<div class="mb-3">
	    <h5 class="card-text">Order Cancel Email</h5>
	    <textarea class="form-control" name="tinymce" id="tmp_order_cancel-editor" rows="10" ></textarea>
		<div class="mt-2">
			<button class="btn btn-primary" :disabled="btn_disabled.tmp_order_cancel" @click="save_content('tmp_order_cancel',data['tmp_order_cancel'])">Save</button>
		</div>
		<hr/>
	</div>

  	<div class="mb-3">
	    <h5 class="card-text">Notification Email</h5>
	    <textarea class="form-control" name="tinymce" id="tmp_notification-editor" rows="10" ></textarea>
		<div class="mt-2">
			<button class="btn btn-primary" :disabled="btn_disabled.tmp_notification" @click="save_content('tmp_notification',data['tmp_notification'])">Save</button>
		</div>
		<hr/>
	</div>
  </div>
</div>
<!-- @include('backoffice.contents.modal.upload-banner-modal') -->