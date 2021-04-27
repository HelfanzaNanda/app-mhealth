<div class="card">
  <div class="card-body">
  	<div class="mb-3">
	    <h5 class="card-text">Notification Email</h5>
	    
		Shorttags:
  		<ul>
  			<li v-html="'@{{CUSTOMER_NAME}}'"></li>
  			<li v-html="'@{{NOTIFICATION_TITLE}}'"></li>
  			<li v-html="'@{{NOTIFICATION_BODY}}'"></li>
  		</ul>
	    <textarea class="form-control" name="tinymce" id="tmp_notification-editor" rows="10" ></textarea>
		<div class="mt-2">
			<button class="btn btn-primary" :disabled="btn_disabled.tmp_notification" @click="save_content('tmp_notification',data['tmp_notification'])">Save</button>
		</div>
		<hr/>
	</div>
  </div>
</div>
<!-- @include('backoffice.contents.modal.upload-banner-modal') -->