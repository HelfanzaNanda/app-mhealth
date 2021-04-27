<div class="card">
  <div class="card-body">
  	<div class="mb-3">
	    <h5 class="card-text">Password Recovery Email</h5>
		Shorttags:
  		<ul>
  			<li v-html="'@{{CUSTOMER_NAME}}'"></li>
  			<li v-html="'@{{RECOVERY_LINK}}'"></li>
  		</ul>
	    <textarea class="form-control" name="tinymce" id="tmp_password_recovery-editor" rows="10" ></textarea>
		<div class="mt-2">
			<button class="btn btn-primary" :disabled="btn_disabled.tmp_password_recovery" @click="save_content('tmp_password_recovery',data['tmp_password_recovery'])">Save</button>
		</div>
		<hr/>
	</div>
  </div>
</div>
<!-- @include('backoffice.contents.modal.upload-banner-modal') -->