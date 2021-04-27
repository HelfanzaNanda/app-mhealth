<div class="card">
  <div class="card-body">
  	<div class="mb-2">
  		Shorttags:
  		<ul>
  			<li>{{CUSTOMER_NAME}}</li>
  			<li>{{ORDER_ID}}</li>
  		</ul>
  	</div>
  	<div class="mb-3">
	    <h5 class="card-text">Order Completed Email</h5>
	    <textarea class="form-control" name="tinymce" id="tmp_order_completed-editor" rows="10" ></textarea>
		<div class="mt-2">
			<button class="btn btn-primary" :disabled="btn_disabled.tmp_order_completed" @click="save_content('tmp_order_completed',data['tmp_order_completed'])">Save</button>
		</div>
		<hr/>
	</div>
  </div>
</div>
<!-- @include('backoffice.contents.modal.upload-banner-modal') -->