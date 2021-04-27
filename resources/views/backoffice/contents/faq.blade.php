<div class="card">
  <div class="card-body">
    <h5 class="card-text">FAQ</h5>
    <textarea class="form-control" name="tinymce" id="faq-editor" rows="10" ></textarea>
	<div class="mt-2">
		<button class="btn btn-primary" :disabled="btn_disabled.faq" @click="save_content('faq',data['faq'])">Update</button>
	</div>
  </div>
</div>
<!-- @include('backoffice.contents.modal.upload-banner-modal') -->