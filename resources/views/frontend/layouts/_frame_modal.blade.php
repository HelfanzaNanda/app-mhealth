@push('styles')
<style type="text/css">
	.modal-frame{
		margin: 0;
		height: 100vh;
		border: 0;
		border-radius: 0;
	}
	.btn-add{
		position: absolute;
		right: 0;
		top: 0;
	}
	.btn-back{
		position: absolute;
		left: 0;
		top: 0px;
	}
	.load-frame{
		border: 0;
		width: 100%;
		height: 100%;
	}
	.fullscreen{
		position: absolute;
		top: 0;
		left: 0;
		box-shadow: unset!important; 

	}
</style>
@endpush
<div  id="frame-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content modal-frame" role="document">
			<div class="container box-shadow" id="frame-header">
		        <div class="align-items-center py-3 position-relative">
		            <div href="" onclick="backButton()" class="py-3 btn-back" aria-hidden="true">
		                <!-- <div class=""> -->
		                    <img src="" width="18" height="18" id="frame-back-img">
		                <!-- </div> -->
		            </div>
		            <div class="justify-content-center">
		            	
		                <div class="font-size-18 text-active-pink font-weight-500 text-center" id="frame-title">Diary Ibu Hamil</div>
		            </div>
		            <div href="" class="py-3 btn-add text-active-pink" aria-hidden="true" style="line-height: 1.8">
		                <!-- <div class=""> -->
		                    
		                <!-- </div> -->
		            </div>
		        </div>
		    </div>
		    <div style="flex-grow: 1;">
		    	<iframe src="" class="load-frame" id="frame-source"></iframe>
		    </div>
		</div>
	</div>
</div>

@push('scripts')

<script type="text/javascript">
	var frameStack=[];
	function backButton(){
		console.log(frameStack);
		frameStack.pop();
		if(frameStack.length>0){
			lastFrame = frameStack[frameStack.length-1];
			openFrame(lastFrame.url,lastFrame.title,lastFrame.prop,false);
		}else{
			$('#frame-modal').modal('hide');
		}
	}
	function openFrame(url,title,prop={},stack=true){
		if(stack)frameStack.push({url:url,title:title,prop:prop});
		$('.btn-add').hide();
		$('#frame-header').removeClass('fullscreen');
		$('#frame-back-img').attr('src','{{ asset('images/icon/back.png') }}');
		if(prop.fullscreen){
			$('#frame-header').addClass('fullscreen');
		}
		if(prop.light){
			$('#frame-back-img').attr('src','{{ asset('images/icon/back-white.png') }}');
		}
		if(prop.button){
			$('.btn-add').show();
			$('.btn-add').html(prop.button.text);
			$('.btn-add').off('click.me');
			$('.btn-add').on('click.me',()=>{
				prop.button.onclick();
			});

		}

		$('#frame-title').html(title);
		$('#frame-source').attr('src',url);
		setTimeout(function(){
			$('#frame-modal').modal('show');
		},100)
	}
</script>
@endpush