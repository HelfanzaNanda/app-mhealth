<div class="card">
  <div class="card-body">
  	<div class="mb-3">
	    <h5 class="card-text">Welcome Email</h5>
		Shorttags:
  		<ul>
  			<li v-html="'@{{CUSTOMER_NAME}}'"></li>
  		</ul>
	    <textarea class="form-control" name="tinymce" id="tmp_welcome-editor" rows="10" ></textarea>
		<div class="mt-2">
			<button class="btn btn-primary" :disabled="btn_disabled.tmp_welcome" @click="save_content('tmp_welcome',data['tmp_welcome'])">Save</button>
		</div>
		<hr/>
	</div>
  </div>
</div>
<!-- @include('backoffice.contents.modal.upload-banner-modal') -->