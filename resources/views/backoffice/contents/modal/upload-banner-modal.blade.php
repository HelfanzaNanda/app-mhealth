<div class="modal" tabindex="-1" role="dialog" id="upload-banner-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Banner Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row mb-2" v-if="!formBanner.id">
          <label class="col-3">Image</label>
          <div class="col-9">
            <input type="file" onclick="this.value=null" id="uploadbanner" name="file" accept="image/*">
            <p style="color: grey;font-size: 12px">* Recomended banner resolution are <strong>1920 x 720px</strong> for desktop and <strong>1080 x 1080</strong> for mobile</p>
          </div>
        </div>
        <div class="row mb-2">
          <label class="col-3">Show on</label>
          <div class="col-9">
            <select v-model="formBanner.type">
              <option value="desktop">Desktop</option>
              <option value="mobile">Mobile</option>
            </select>
          </div>
        </div>
        <div class="row mb-2">
          <label class="col-3">Link</label>
          <div class="col-9">
            <input type="text" class="form-control" placeholder="https://......." v-model="formBanner.link">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" @click="UploadBanner()">Save</button>
      </div>
    </div>
  </div>
</div>
