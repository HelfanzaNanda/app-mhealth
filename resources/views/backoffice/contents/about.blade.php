<div class="card">
  <div class="card-body">
    <h5 class="card-text">About</h5>
    <textarea class="form-control" name="tinymce" id="about-editor" rows="10" ></textarea>
	<div class="mt-2">
		<button class="btn btn-primary" :disabled="btn_disabled.about" @click="save_content('about',data['about'])">Update</button>
	</div>
  </div>
</div>
<!-- @include('backoffice.contents.modal.upload-banner-modal') -->