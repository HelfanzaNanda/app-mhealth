<div class="card">
  <div class="card-body">
  	<div class="mb-3">
	    <h5 class="card-text">Order Placed Email</h5>
		Shorttags:
  		<ul>
  			<li v-html="'@{{CUSTOMER_NAME}}'"></li>
  			<li v-html="'@{{ORDER_ID}}'"></li>
  			<li v-html="'@{{ORDER_DATA}}'"></li>
  		</ul>
	    <textarea class="form-control" name="tinymce" id="tmp_order_placed-editor" rows="10" ></textarea>
		<div class="mt-2">
			<button class="btn btn-primary" :disabled="btn_disabled.tmp_order_placed" @click="save_content('tmp_order_placed',data['tmp_order_placed'])">Save</button>
		</div>
		<hr/>
	</div>
  </div>
</div>
<!-- @include('backoffice.contents.modal.upload-banner-modal') -->