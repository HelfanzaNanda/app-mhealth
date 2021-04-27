<div class="card">
  <div class="card-body">
    <h5 class="card-text">Contact</h5>
    <textarea class="form-control" name="tinymce" id="contact-editor" rows="10" ></textarea>
	<div class="mt-2">
		<button class="btn btn-primary" :disabled="btn_disabled.contact" @click="save_content('contact',data['contact'])">Update</button>
	</div>
  </div>
</div>
<!-- @include('backoffice.contents.modal.upload-banner-modal') -->