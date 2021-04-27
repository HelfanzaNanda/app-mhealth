<div class="card">
  <div class="card-body">
    <h5 class="card-text">Privacy &amp; Policy</h5>
    <textarea class="form-control" name="tinymce" id="privacy-editor" rows="10" ></textarea>
	<div class="mt-2">
		<button class="btn btn-primary" :disabled="btn_disabled.privacy" @click="save_content('privacy',data['privacy'])">Update</button>
	</div>
  </div>
</div>
<!-- @include('backoffice.contents.modal.upload-banner-modal') -->