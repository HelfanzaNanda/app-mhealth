 <div class="card">
    <div class="card-body">
    	<h5>Custom Section</h5>
    	<div>
            <div class="row">
                <div class="col-3">Show Custom Section</div>
                <div class="col-6">
                    <select v-model="data.show_fabric_section">
                        <option value="1">Enable</option>
                        <option value="0">Disable</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-3">Custom Section Title</div>
                <div class="col-6">
                    <input v-model="data.custom_section_title" placeholder="ex. Trending in woman" class="form-control"> 
                </div>
            </div>
    		<input type="file" hidden="" id="image1-file" accept="image/*" onclick="this.value=null" @change="ImageChange($event,'fabric_section_image1_file')">
    		<input type="file" hidden="" id="image2-file" accept="image/*" onclick="this.value=null" @change="ImageChange($event,'fabric_section_image2_file')">
    		<input type="file" hidden="" id="image3-file" accept="image/*" onclick="this.value=null" @change="ImageChange($event,'fabric_section_image3_file')">
    	</div>
    	<div v-if="data.show_fabric_section">
    		<div class="row">
    			<div class="col-6" >
    				<div style="border:1px solid black;padding:10px">
    					<h6>Display Image 1</h6>
    					<div class="text-center mb-1">
    						<img :src="'{{config('app.API_URL')}}/'+data.fabric_section_image1_file??'public/noimage.php'" style="width: 100%;">
                            <div class="text-right">
                                <button class="btn btn-xs btn-primary" @click="OpenImageTag(data,data.fabric_section_image1_file,'fabric_section_image1_popper')">Image Tag</button>
                            </div>
    					</div>
    					<div class="text-center">
    						<p class="text-center" style="font-size:12px;color:grey;">*Recomended size 1024x1024 (1:1)</p>
    						<button class="btn btn-sm btn-primary" onclick="$('#image1-file').click()"><i style="width:12px;height:12px;" data-feather="upload"></i> Upload</button>
    					</div>
    					<div class="input-group mb-1">
							<div class="input-group-prepend">
    							<span class="input-group-text">Link</span>
    						</div>
    						<input type="text" class="form-control" v-model="data.fabric_section_image1_link">
    					</div>
    					<div class="input-group mb-1">
							<div class="input-group-prepend">
    							<span class="input-group-text">Button Text</span>
    						</div>
    						<input type="text" class="form-control" v-model="data.fabric_section_image1_button" placeholder="Explore">
    					</div>
    					<div class="input-group mb-1">
							<div class="input-group-prepend">
    							<span class="input-group-text">Caption</span>
    						</div>
    						<input type="text" class="form-control" v-model="data.fabric_section_image1_text" placeholder="Shop Exlusive Range of">
    					</div>
    					<div class="input-group mb-1">
							<div class="input-group-prepend">
    							<span class="input-group-text">Title</span>
    						</div>
    						<input type="text" class="form-control" v-model="data.fabric_section_image1_title">
    					</div>
    				</div>
    			</div>
    			<div class="col-6">
    				<div style="border:1px solid black;padding:10px" class="mb-1">
    					<h6>Display Image 2</h6>
    					<div class="row">
    						<div class="col-4">   
    							<div class="text-center mb-1">
    								<img :src="'{{config('app.API_URL')}}/'+data.fabric_section_image2_file??'public/noimage.php'" style="width: 100%;">
                                    <div class="text-right">
                                        <button class="btn btn-xs btn-primary" @click="OpenImageTag(data,data.fabric_section_image2_file,'fabric_section_image2_popper')">Image Tag</button>
                                    </div>
    							</div>
    							<div class="text-center">
    								<p class="text-center" style="font-size:12px;color:grey;">*Recomended size 1024x1024 (1:1)</p>
    								<button class="btn btn-sm btn-primary" onclick="$('#image2-file').click()"><i style="width:12px;height:12px;" data-feather="upload"></i> Upload</button>
    							</div>
    						</div>
    						<div class="col-8">
		    					<div class="input-group mb-1" class="input-group mb-1">
									<div class="input-group-prepend">
		    							<span class="input-group-text">Link</span>
		    						</div>
		    						<input type="text" class="form-control" v-model="data.fabric_section_image2_link">
		    					</div>
		    					<div class="input-group mb-1" class="input-group mb-1">
									<div class="input-group-prepend">
		    							<span class="input-group-text">Button Text</span>
		    						</div>
		    						<input type="text" class="form-control" v-model="data.fabric_section_image2_button" placeholder="Explore">
		    					</div>
		    					<div class="input-group mb-1" class="input-group mb-1">
									<div class="input-group-prepend">
		    							<span class="input-group-text">Caption</span>
		    						</div>
		    						<input type="text" class="form-control" v-model="data.fabric_section_image2_text" placeholder="Shop Exlusive Range of">
		    					</div>
		    					<div class="input-group mb-1" class="input-group mb-1">
									<div class="input-group-prepend">
		    							<span class="input-group-text">Title</span>
		    						</div>
		    						<input type="text" class="form-control" v-model="data.fabric_section_image2_title">
		    					</div>

    						</div>
    					</div>
						
    				</div>
    				<div style="border:1px solid black;padding:10px">
    					<h6>Display Image 3</h6>
    					<div class="row">
    						<div class="col-4">
    							<div class="text-center mb-1">
    								<img :src="'{{config('app.API_URL')}}/'+data.fabric_section_image3_file??'public/noimage.php'" style="width: 100%;">
                                    <div class="text-right">
                                        <button class="btn btn-xs btn-primary" @click="OpenImageTag(data,data.fabric_section_image1_file,'fabric_section_image1_popper')">Image Tag</button>
                                    </div>
    							</div>
    							<div class="text-center">
    								<p class="text-center" style="font-size:12px;color:grey;">*Recomended size 1024x1024 (1:1)</p>
    								<button class="btn btn-sm btn-primary" onclick="$('#image3-file').click()"><i style="width:12px;height:12px;" data-feather="upload"></i> Upload</button>
    							</div>
    						</div>
    						<div class="col-8">
    							
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text">Link</span>
									</div>
									<input type="text" class="form-control" v-model="data.fabric_section_image3_link">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text">Button Text</span>
									</div>
									<input type="text" class="form-control" v-model="data.fabric_section_image3_button" placeholder="Explore">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text">Caption</span>
									</div>
									<input type="text" class="form-control" v-model="data.fabric_section_image3_text" placeholder="Shop Exlusive Range of">
								</div>
								<div class="input-group mb-1">
									<div class="input-group-prepend">
										<span class="input-group-text">Title</span>
									</div>
									<input type="text" class="form-control" v-model="data.fabric_section_image3_title">
								</div>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
      
      <div class="mt-1" >
        <button class="btn btn-sm btn-primary" @click="save_content_batch()" >Save</button>
      </div>

    </div>
  </div>

