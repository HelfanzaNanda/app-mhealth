<div class="card">
  <div class="card-body">
    <h5 class="card-text">Terms &amp; Conditions</h5>
    <textarea class="form-control" name="tinymce" id="term-editor" rows="10" ></textarea>
	<div class="mt-2">
		<button class="btn btn-primary" :disabled="btn_disabled.term" @click="save_content('term',data['term'])">Update</button>
	</div>
  </div>
</div>
<!-- @include('backoffice.contents.modal.upload-banner-modal') -->