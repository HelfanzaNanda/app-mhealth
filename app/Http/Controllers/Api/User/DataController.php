<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;

use GuzzleHttp\Client;
use ReallySimpleJWT\Token;
use Exception;
use Request;
use DB;
use Cache;
class DataController extends ApiController
{
	public function cron_push(){
		$queue=DB::table('notification_queue_item')
				->select('notification.*','notification_queue_item.*')
				->join('notification','notification_queue_item.notificationid','notification.id')
				->where('notification_queue_item.push_status','pending')
				->orderBy('notification.created_at','DESC')
				->limit(500)
				->get();
		// echo "QUEUE LIST".PHP_EOL;			
		// print_r($queue);
		// echo PHP_EOL;			
		$ids = $queue->pluck('id')->toArray();
		DB::table('notification_queue_item')->whereIn('id',$ids)->update(['push_status'=>'sending']);
		foreach ($queue as $row) {
			// echo "sending ".$row->email.PHP_EOL;			
			$data = $this->send_push_notification($row->email,$row->title,$row->body);	
			// if(!isset($data->recipients) || (isset($data->recipients) && $data->recipients==0)){
				
			// }
			$body = "<p style='text-align:center'>".$row->body."<br/><br/><a href='".$this->settings['url']."' style='font-size:20px'>Click here to Visit Ethnic India</a></p>";
				$data = $this->send_email($row->email,$row->title,$body);	
			print_r($data);
			// echo PHP_EOL;			
		}
		DB::table('notification_queue_item')->whereIn('id',$ids)->update(['push_status'=>'sent']);

	}
	public function check_cod(){
		$pincode = request()->input('pincode');
		$data = $this->call_delhivery('pin-codes/json/?filter_codes='.$pincode);
		// print_r($data);
		if (!isset($data->delivery_codes)) {
			return response()->json(['status'=>0,'msg'=>"Failed to get information"]);
		}
		if(count($data->delivery_codes)==0){
			return response()->json(['status'=>0,'msg'=>"Couldn't find pincode"]);
		}
		if(empty($data->delivery_codes[0]->postal_code)){
			return response()->json(['status'=>0,'msg'=>"Couldn't find pincode"]);
		}
		$result =$data->delivery_codes[0]->postal_code;
		return response()->json(['status'=>1,'result'=>$result]);
	}
	public function get_faq(){
		$result = DB::table('faq')->get();
		return response()->json(['status'=>1,'result'=>$result]);
	}
	public function base_content(){
		$userdata = $this->jwt_data['userdata'];
		$uuid = request()->input('uuid')??rand(0,9999);
		if($userdata){
			$uuid=$userdata->id;
		}

		$list =Cache::rememberForever('category.all', function () {
			return DB::table('category')
			->orderBy('name','ASC')->get();
		});
		foreach ($list as &$row) {
			// $row->product= Cache::rememberForever('product.related.'.$product->id, function ()use($product) { 

			// 	return DB::table('contact')
			// 		->select('contact.*','s.id as s_id','c.id as c_id',DB::raw("CONCAT(IFNULL(c.slug,s.slug), '/', s.slug, '/', contact.slug) as slug"))
			// 		->leftJoin('contact_category','contact.id','=','contact_category.productid')
			// 		->leftJoin(DB::raw('category as s'),'s.id','=','contact_category.categoryid')
			// 		->leftJoin(DB::raw('category as c'),'c.id','=','s.parentid')
			// 		->where('contact.type','product')
			// 		->where(function($query)use($row){
			// 			$query->orWhere('c.id',$row->id);
			// 		})
			// 		->limit(3)
			// 		->get();
			// 		$row->product=$this->get_product_images($row->product);
			// 	}):
			
		}
		$category=[];
		foreach ($list as $row) {
			if($row->parentid==0){
				$sub=[];
				foreach ($list as $row2) {
					if($row2->parentid==$row->id){
						$sub[$row2->slug]=$row2;
					}
				}
				$row->sub=$sub;
				$category[$row->slug]=$row;

			}
		}
		$header_menu = Cache::rememberForever('header.menu', function () {
					return DB::table('menu')
					->orderBy('position','ASC')
					->get();
				});
		
		foreach ($header_menu as &$row) {
			$row->submenu=Cache::rememberForever('header.submenu.'.$row->id, function ()use($row) {
				return DB::table('submenu')
							->where('menuid',$row->id)
							->orderBy('title','ASC')
							->get();
					});
		}
		$r = DB::table('site_content')->get();
		$content = [];
		foreach ($r as $row) {
			$content[$row->name]=$row->value;
		}
		if(isset($content['login_incentive']) && $content['login_incentive']==1){
			$content['login_coupon']=DB::table('coupon')->where('code',$content['login_coupon_code'])->orderBy('id','DESC')->first();
		}
		if(isset($content['first_order_incentive']) && $content['first_order_incentive']==1){
			$content['first_order_coupon']=DB::table('coupon')->where('code',$content['first_order_coupon_code'])->orderBy('id','DESC')->first();
		}
		$content['trending_keywords']=explode(',', $content['trending_keywords']);
		$content['popular_product']=Cache::rememberForever('popular.product.', function ()use($content) {

			return DB::table('contact')
								->select('contact.*',
									DB::raw("CONCAT(IF(c.slug IS NOT NULL,CONCAT(c.slug,'/'),''), s.slug, '/', contact.slug) as slug"))
								->leftJoin('contact_category','contact.id','=','contact_category.productid')
								->leftJoin(DB::raw('category as s'),'s.id','=','contact_category.categoryid')
								->leftJoin(DB::raw('category as c'),'c.id','=','s.parentid')
								->where('contact.show_as_popular',1)
								->where('contact.is_deleted',0)
								->where('contact.is_active',1)
								->where('contact.type','!=','variant_product')
								->orderBy(DB::raw('RAND()'))
								->limit((int)$content['popular_product_count'])
								->get();
							});


		$content['popular_product']=$this->get_product_images($content['popular_product']);
		$content['push_product']=null;
		if($content['push_product_by']=='random'){

			$content['push_product']=Cache::remember('push.product.random2', 15,function () {
				return DB::table('contact')
								->select('contact.*',
									DB::raw("CONCAT(IF(c.slug IS NOT NULL,CONCAT(c.slug,'/'),''), s.slug, '/', IFNULL(contact.slug,'')) as slug"))
								->leftJoin('contact_category','contact.id','=','contact_category.productid')
								->leftJoin(DB::raw('category as s'),'s.id','=','contact_category.categoryid')
								->leftJoin(DB::raw('category as c'),'c.id','=','s.parentid')
								->where('contact.is_active',1)
								->where('contact.is_deleted',0)
								->where('contact.type','!=','product-variant')
								->orderBy(DB::raw('RAND()'))
								->first();
							});
		}elseif($content['push_product_by']=='popular'){
			$content['push_product']=Cache::remember('push.product.popular2', 15,function () {
				return DB::table('contact')
								->select('contact.*',
									DB::raw("CONCAT(IF(c.slug IS NOT NULL,CONCAT(c.slug,'/'),''), s.slug, '/', IFNULL(contact.slug,'')) as slug"))
								->leftJoin('contact_category','contact.id','=','contact_category.productid')
								->leftJoin(DB::raw('category as s'),'s.id','=','contact_category.categoryid')
								->leftJoin(DB::raw('category as c'),'c.id','=','s.parentid')
								->where('contact.is_active',1)
								->where('contact.is_deleted',0)
								->where('contact.type','!=','product-variant')
								->whereRaw("contact.id IN (SELECT id FROM contact ORDER BY views DESC)")
								->orderBy(DB::raw('RAND()'))
								->first();
							});
		}elseif($content['push_product_by']=='trending'){
			$content['push_product']=Cache::remember('push.product.trending2',15, function () {
				return DB::table('contact')
								->select('contact.*',
									DB::raw("CONCAT(IF(c.slug IS NOT NULL,CONCAT(c.slug,'/'),''), s.slug, '/', IFNULL(contact.slug,'')) as slug"))
								->leftJoin('contact_category','contact.id','=','contact_category.productid')
								->leftJoin(DB::raw('category as s'),'s.id','=','contact_category.categoryid')
								->leftJoin(DB::raw('category as c'),'c.id','=','s.parentid')
								->where('contact.is_active',1)
								->where('contact.is_deleted',0)
								->where('contact.type','!=','product-variant')
								->whereRaw("contact.id IN (SELECT id FROM contact p ORDER BY views DESC)")
								->orderBy(DB::raw('RAND()'))
								->first();
							});
		}
		$content['fabric_section_image1_popper']=json_decode($content['fabric_section_image1_popper'])??[];
		$content['fabric_section_image2_popper']=json_decode($content['fabric_section_image2_popper'])??[];
		$content['fabric_section_image3_popper']=json_decode($content['fabric_section_image3_popper'])??[];
		$content['push_product']=$this->get_product_images_single($content['push_product']);
		// print_r($content['push_product']);
		$blog=DB::table('blog_category')->orderBy('name','asc')->get();
		$size_guide = DB::table('size_guide')->get();

		$fabric_estimator_category = Cache::rememberForever('fabric.estimator.', function () {
			return DB::table('fabric_estimator_category')->where('parentid',0)->orderBy('name')->get();
		});
		foreach($fabric_estimator_category as &$cat){

			$subcategory = Cache::rememberForever('fabric.estimator.subcategory'.$cat->id, function ()use($cat) {
				return DB::table('fabric_estimator_category')->where('parentid',$cat->id)->orderBy('name')->get();
			});
			foreach ($subcategory as &$sub) {
				$sub->apparels=Cache::rememberForever('apparels.sub.'.$sub->id, function ()use($sub) {
					return DB::table('fabric_estimator')->where('fecategoryid',$sub->id)->orderBy('name')->get();
				});
			}
			$cat->subcategory=$subcategory;
		}

		$recomended_id = DB::table('user_suggestion')->where('customerid',$uuid)->get()->pluck('productid')->toArray();
		if(count($recomended_id)<8){
			$new_id = DB::table('contact')->orderBy('views','DESC')->limit((8-count($recomended_id)))->pluck('id')->toArray();
			foreach ($new_id as $id) {
				$recomended_id[]=$id;
			}
		}
		$recomended =DB::table('contact')
					->select('contact.*',
						DB::raw("CONCAT(IF(c.slug IS NOT NULL,CONCAT(c.slug,'/'),''), s.slug, '/', contact.slug) as slug"))
					->leftJoin('contact_category','contact.id','=','contact_category.productid')
					->leftJoin(DB::raw('category as s'),'s.id','=','contact_category.categoryid')
					->leftJoin(DB::raw('category as c'),'c.id','=','s.parentid')
					->where('contact.type','product')
					->where('contact.is_deleted',0)
					->where('contact.is_active',1)
					->whereIn('contact.id',$recomended_id)
					->orderBy(DB::raw("RAND()"))
					->limit(8)
					->get();
		$recomended = $this->get_product_images($recomended);
		$pages_all = DB::table('page')->get();
		$pages = [];
		foreach ($pages_all as $page) {
			$pages[$page->slug]=$page;
		}
		$result=[
			'header'=>$category,
			'header_menu'=>$header_menu,
			'blog'=>$blog,
			'content'=>$content,
			'size_guide'=>$size_guide,
			'fabric_estimator_category'=>$fabric_estimator_category,
			'recomended'=>$recomended,
			'pages'=>$pages,
		];
		return response()->json(['status'=>1,'result'=>$result]);

	}
	public function list_category(){
		$list = DB::table('category')
			->orderBy('name','ASC')->get();
		$category=[];
		foreach ($list as $row) {
			if($row->parentid==0){
				//$category[]=$row;
				$sub=[];
				foreach ($list as $row2) {
					if($row2->parentid==$row->id){
						$sub[$row2->id]=$row2;
					}
				}
				$row->sub=$sub;
				$category[$row->id]=$row;
			}
		}
		
		return response()->json(['status'=>1,'result'=>$category]);

	}
	public function get_collection_by_slug(){
		$slug = request()->input('slug');
		$collection = DB::table('collection')->where('slug',$slug)->first();
		return response()->json(['status'=>1,'result'=>$collection]);
	}
	public function get_category_by_slug(){
		$slug = request()->input('slug');
		$category = DB::table('category')->where('slug',$slug)->first();
		return response()->json(['status'=>1,'result'=>$category]);
	}
	public function get_blog_category_by_slug(){
		$slug = request()->input('slug');
		$category = DB::table('blog_category')->where('slug',$slug)->first();
		return response()->json(['status'=>1,'result'=>$category]);
	}
	public function list_collection(){
		$collection = DB::table('collection')->orderBy('created_at','DESC')->get();
		return response()->json(['status'=>1,'result'=>$collection]);
	}
	public function list_lookbook(){
		$influencer_list =DB::table('influencer')
			->orderBy('name','DESC')->get();

		$lookbook_list =DB::table('lookbook')->get();
		$lookbook_item_list =DB::table('lookbook_product')
						->select('contact.*','lookbook_product.lookbookid')
						->join('contact','lookbook_product.productid','contact.id')
						->where('contact.is_deleted',0)
						->where('contact.is_active',1)
						->get();
		$lookbook_item_list=$this->get_product_images($lookbook_item_list);
		$list=[];
		foreach ($influencer_list as $influencer) {
			$list_look=[];
			$i=0;
			foreach ($lookbook_list as $look) {
				if($look->influencerid==$influencer->id){
					$list_item=[];
					$i++;
					$look->label=$i;
					foreach ($lookbook_item_list as $item) {
						if($item->lookbookid==$look->id){
							$list_item[]=$item;
						}
					}
					$look->items=$list_item;
					$list_look[] = $look;
				}
			}
			$influencer->look=$list_look;
			$influencer->index=0;
			$list[]=$influencer;
		}
		return response()->json(['status'=>1,'result'=>$list]);

	}
	
	public function home(){
		$banner = Cache::rememberForever('banner.', function () {
			return DB::table('banner')
			->orderBy('created_at','DESC')->get();
		});

		$categories =Cache::rememberForever('categories.orderparent', function () {
			DB::table('category')
			->orderBy('parentid','ASC')
			->orderBy('name','ASC')
			->get();
		});

		$fabrics =DB::table('category')
			->select('category.*')
			->join(DB::raw("category as c"),"c.id",'category.parentid')
			->where('c.slug','fabrics')
			->get();
		$query = Cache::rememberForever('site.content.price.filter', function () {
			return DB::table('site_content')->where('name','price_filter')->first();
		});
		$price_list = explode(',', ($query->value??''));
		$shop_by_price=[];
		
		foreach ($price_list as $pricemin) {
			$product =  Cache::rememberForever('product.pricemin.'.$pricemin, function ()use($pricemin) {
				return DB::table('contact')
				->select('contact.*',
					DB::raw("CONCAT(IF(c.slug IS NOT NULL,CONCAT(c.slug,'/'),''), s.slug, '/', contact.slug) as slug"))
				->leftJoin('contact_category','contact.id','=','contact_category.productid')
				->leftJoin(DB::raw('category as s'),'s.id','=','contact_category.categoryid')
				->leftJoin(DB::raw('category as c'),'c.id','=','s.parentid')
				->where('contact.type','product')
				->where('contact.is_deleted',0)
				->where('contact.is_active',1)
				->where('contact.price','>',$pricemin)
				->orderBy('contact.price','ASC')
				->first();
			});
			if($product){
				$product->startprice = $pricemin ;
				$shop_by_price[] = $this->get_product_images_single($product);
			}
		
		}

		

		$collection1=DB::table('collection')->get();

		$recent_buy =  Cache::rememberForever('site.content.price.filter', function () {
			return DB::table('contact')
								->select('contact.*',
									DB::raw("CONCAT(IF(c.slug IS NOT NULL,CONCAT(c.slug,'/'),''), s.slug, '/', contact.slug) as slug"))
								->leftJoin('contact_category','contact.id','=','contact_category.productid')
								->leftJoin(DB::raw('category as s'),'s.id','=','contact_category.categoryid')
								->leftJoin(DB::raw('category as c'),'c.id','=','s.parentid')
								->where('contact.is_deleted',0)
								->where('contact.is_active',1)
								->orderBy(DB::raw("RAND()"))->first();
							});
		$recent_buy = $this->get_product_images_single($recent_buy);

		$home_categories =  Cache::rememberForever('categories.home', function () {
					return DB::table('category')
							->where('show_on_home',1)
							->get();
						});

		$lookbook =  Cache::rememberForever('lookbook', function () {
			 return DB::table('lookbook')->where('show_on_home',1)->get();
			});
		foreach ($lookbook as &$look) {
			$look->product = Cache::rememberForever('lookbook.product.'.$look->id, function ()use($look) {
				return DB::table('lookbook_product')
								->select('contact.*')
								->join('contact','contact.id','lookbook_product.productid')
								->where('lookbookid',$look->id)->get();
							});
			$look->product = $this->get_product_images($look->product);
		}
		$userdata = $this->jwt_data['userdata'];
		$notification=null;
		if(isset($userdata->email)){
			$notification = DB::table('notification_queue_item')
								->select('notification.*','notification_queue_item.*')
								->join('notification','notification.id','notification_queue_item.notificationid')
								->where('notification_queue_item.email',$userdata->email)
								->where('notification_queue_item.status','sent')
								->where('notification.type','coupon')
								->orderBy('notification.created_at')
								->first();
			if($notification){
				$notification->coupon=DB::table('coupon')->where('code',$notification->data)->orderBy('id','DESC')->first();	
				DB::table('notification_queue_item')->where('id',$notification->id)->update(['status'=>'read']);
			}
		}
		$blog=Cache::rememberForever('product.blog.homev7', function ()use($product) {
		return DB::table('blog')
				->select('blog.title','blog.slug','blog.id','blog.image','blog_category.name as category')
				->leftJoin('blog_product','blog_product.blogid','blog.id')
				->leftJoin('blog_category','blog_category.id','blog.categoryid')
				->orderBy('blog.created_at','DESC')
				->limit(3)
				->get();
			});
		$result=[
			'banner'=>$banner,
			'categories'=>$categories,
			'collection'=>[],
			'fabrics'=>$fabrics,
			'collection1'=>$collection1,
			'lookbook'=>$lookbook,
			'shop_by_price'=>$shop_by_price,
			'recent_buy'=>$recent_buy,
			'home_categories'=>$home_categories,
			'notification'=>$notification,
			'blog'=>$blog,
		];
		return response()->json(['status'=>1,'result'=>$result]);

	}
	public function subscribe(){
		$email = request()->input('email');
		if(!DB::table('mail_list')->where('email',$email)->exists()){
			DB::table('mail_list')->insert([
				'email'=>$email,
				'created_at'=>date("Y-m-d H:i:s")
			]);
		}
		return response()->json(['status'=>1]);
	}
	public function list_banner(){
		$list =DB::table('banner')
			->orderBy('created_at','DESC')->get();
		return response()->json(['status'=>1,'result'=>$list]);

	}
	public function list_blog(){
		$category=request()->input('category');
		$list =DB::table('blog')
			->select('blog.*','blog_category.name as category')
			->join('blog_category','blog_category.id','blog.categoryid')
			->where(function($query)use($category){
				if(!empty($category)){
					$query->where('blog_category.slug',$category);
				}
			})
			->orderBy('created_at','DESC')->get();
		$category=DB::table('blog_category')->where('slug',$category)->first();
		return response()->json(['status'=>1,'result'=>['list'=>$list,'category'=>$category]]);

	}
	public function list_fabric(){
		$list =DB::table('contact')
								->select('contact.*',
									DB::raw("CONCAT(IF(c.slug IS NOT NULL,CONCAT(c.slug,'/'),''), s.slug, '/', contact.slug) as slug"))
								->leftJoin('contact_category','contact.id','=','contact_category.productid')
								->leftJoin(DB::raw('category as s'),'s.id','=','contact_category.categoryid')
								->leftJoin(DB::raw('category as c'),'c.id','=','s.parentid')
								->orderBy('contact.created_at','DESC')->limit(8)->get();
			$list=$this->get_product_images($list);
		return response()->json(['status'=>1,'result'=>$list]);

	}
	public function get_content(){
		$name = request()->input('name');

		$content=Cache::rememberForever('lookbook', function () {
			return DB::table('site_content')->where('name',$name)->first();
		});
		
		return response()->json(['status'=>1,'result'=>((isset($content->value)?$content->value:''))]);
		

	}

	public function list_color(){
		$list =DB::table('color')
			->orderBy('name','ASC')->get();
		return response()->json(['status'=>1,'result'=>$list]);

	}

	public function list_provice(){
		$list =DB::table('province')
			->orderBy('name','ASC')->get();

		return response()->json(['status'=>1,'result'=>$list]);

	}
	public function list_city(){
		$list =DB::table('city')
			->orderBy('name','ASC')->get();

		return response()->json(['status'=>1,'result'=>$list]);

	}
	public function list_district(){
		$list =DB::table('district')
			->orderBy('name','ASC')->get();

		return response()->json(['status'=>1,'result'=>$list]);

	}
	public function list_state(){
		$list =DB::table('state')
			->orderBy('name','ASC')->get();

		return response()->json(['status'=>1,'result'=>$list]);

	}
	public function list_payment_method(){
		$list =DB::table('payment_method')
			->orderBy('name','ASC')->get();

		return response()->json(['status'=>1,'result'=>$list]);

	}
	public function get_blog_page(){
		$recent_article = DB::table('blog')->select('blog.id','blog.slug','blog.title','blog.created_at')->orderBy('created_at','DESC')->limit(4)->get();

		$recent_article_ids = $recent_article->pluck('id')->toArray();
		$featured_product = Cache::rememberForever('blog.page.'.serialize($recent_article_ids), function ()use($recent_article_ids) {
			return DB::table('contact')
								->select('contact.*',
									DB::raw("CONCAT(IF(c.slug IS NOT NULL,CONCAT(c.slug,'/'),''), s.slug, '/', contact.slug) as slug"))
								->leftJoin('contact_category','contact.id','=','contact_category.productid')
								->leftJoin(DB::raw('category as s'),'s.id','=','contact_category.categoryid')
								->leftJoin(DB::raw('category as c'),'c.id','=','s.parentid')
								->join('blog_product','blog_product.productid','contact.id')
								->whereIn('blog_product.blogid',$recent_article_ids)
								->get();
							});
		$featured_product = $this->get_product_images($featured_product);
		// $home_article = DB::table('blog')
		// 						->orderBy()
		// 						->limit()
		// 						->get();
		$category = Cache::rememberForever('blog.category', function ()use($recent_article_ids) {
				return DB::table('blog_category')->get();
		});
		$data = [
			'category'=>$category,
			'recent_article'=>$recent_article,
			'featured_product'=>$featured_product,
			// 'home_article'=>$home_article
		];

		return response()->json(['status','result'=>$data]);
	}
}
