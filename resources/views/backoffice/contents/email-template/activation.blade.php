<div class="card">
  <div class="card-body">
  	<div class="mb-3">
	    <h5 class="card-text">Activation Email</h5>
		Shorttags:
  		<ul>
  			<li v-html="'@{{CUSTOMER_NAME}}'"></li>
  			<li v-html="'@{{ACTIVATION_CODE}}'"></li>
  			<li v-html="'@{{ACTIVATION_LINK}}'"></li>
  		</ul>
	    <textarea class="form-control" name="tinymce" id="tmp_activation-editor" rows="10" ></textarea>
		<div class="mt-2">
			<button class="btn btn-primary" :disabled="btn_disabled.tmp_activation" @click="save_content('tmp_activation',data['tmp_activation'])">Save</button>
		</div>
		<hr/>
	</div>
</div>
<!-- @include('backoffice.contents.modal.upload-banner-modal') -->