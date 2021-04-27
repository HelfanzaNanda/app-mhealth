<div class="card">
  <div class="card-body">
    <div class="d-flex  justify-content-between align-items-center flex-wrap grid-margin">
      <h5 class="card-text">Home Page Banner Slider</h5>
      <div class="align-items-center flex-wrap text-nowrap text-right">
        <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0" @click="openBannerModal()">
          <i class="btn-icon-prepend" data-feather="plus"></i>
          Insert
        </button>

      </div>
    </div>
    <div style="height: 500px;overflow-y: auto;">
      <table class="table table-bordered table-hovered table-striped">
        <thead>
          <tr>
            <th align="center">#</th>
            <th>Preview</th>
            <th>Show on</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="row in listBanner">
            <td align="center" width="30px">@{{row.no}}</td>
            <td><img :src="'{{config('app.API_URL')}}/'+row.preview" style="border-radius:0;width: 100%;height: auto;" /></td>
            <td>@{{row.type}}</td>
            <td width="40%">
              <div>Link : <a :href="row.link" >@{{row.link}}</a></div>
              <div>Date : @{{row.created_at}}</div>
              <div>
                <button class="btn btn-sm btn-primary" @click="EditBanner(row)"><i data-feather="edit" style="width:12px;height: 12px;"></i> Edit Link</button>
                <button class="btn btn-sm btn-danger" @click="DeleteBanner(row)"><i data-feather="trash" style="width:12px;height: 12px;"></i> Delete</button>
              </div>

            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@include('backoffice.contents.modal.upload-banner-modal')