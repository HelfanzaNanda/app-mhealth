<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
      <h4 class="mb-3 mb-md-0">Blogs</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
      <!-- 
      <button type="button" class="btn btn-outline-primary btn-icon-text mr-2 mb-2 mb-md-0">
        <i class="btn-icon-prepend" data-feather="upload"></i>
        Import
      </button> -->
      <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0" @click="Insert()">
        <i class="btn-icon-prepend" data-feather="plus"></i>
        New Item
      </button>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <div class="form-inline mb-2">
        
          
          <select v-model="order" class="form-control form-control-sm">
            <option value="asc">A-Z</option>
            <option value="desc">Z-A</option>
          </select>
        </div>
      </div>
      <div class="row mb-2">
            <div class="col-6">
              <p style="color: grey;">Result <strong>@{{total}}</strong> </p>
            </div>
            <div class="col-6">
              <div style="color: grey; text-align: right;">
                <div style="display: inline-flex;">
                  <span style="margin-top: 5px">Page </span>
                  <select v-model="page" style="width: 100px" class="form-control form-control-sm mx-1">
                    <option v-for="i in totalpage" :value="i">@{{i}}</option>
                  </select> 
                  <span style="margin-top: 5px">of <strong>@{{totalpage}}</strong></span>
                </div>
              </div>
            </div>
          </div>
        <div>
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th width="10px">#</th>
            <th>Title</th>
            <!-- <th>Category</th> -->
            <th>Status</th>
            <!-- <th>Price</th> -->
            <th>Views</th>
            <th>Rating</th>
            <th>Created at</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="isLoading">
            <td colspan="8" class="text-center">
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="isLoading"></span>
            </td>
          </tr>
          <tr v-if="!isLoading && listData.length==0">
            <td colspan="8" class="text-center">
              No data
            </td>
          </tr>
          <tr v-for="row in listData">
            <td>@{{row.no}}</td>
            <td>@{{row.title}}</td>
            <!-- <td>@{{row.category}}</td> -->
            <td>@{{row.is_active}}</td>
            <!-- <td>@{{row.price}}</td> -->
            <td>@{{row.views}}</td>
            <td>@{{row.rating}}</td>
            <td>@{{row.created_at}}</td>
            <td>
              <button class="btn btn-sm btn-primary btn-icon-text " @click="Edit(row.id)">
                <i style="width: 12px;height: 12px;" data-feather="edit"></i>
              </button>
              <button class="btn btn-sm btn-danger btn-icon-text " @click="Delete(row)">
                <i style="width: 12px;height: 12px;" data-feather="trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      
    </div>
  </div>