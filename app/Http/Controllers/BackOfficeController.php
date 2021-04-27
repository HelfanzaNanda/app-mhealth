<?php

namespace App\Http\Controllers;
use Guzzle;
use Requset;
use Route;
use DB;
class BackOfficeController extends Controller
{
	public $settings =null;
	function __construct(){
		$except = ['login'];
		$jwt_data = $this->jwt_data();
		if(in_array(Route::getCurrentRoute()->getActionMethod(), $except)){
			if(isset($jwt_data['userdata'])){
				// var_dump($jwt_data['userdata']);
				redirect()->to('backoffice/')->send();
				return;
			}
		}else{
			if(!isset($jwt_data['userdata'])){
				redirect()->to('backoffice/login')->send();
				return;
			}
		}
		$result = DB::table('site_content')->get();
		$data = [];
		foreach ($result as $row) {
			$data[$row->name]=$row->value;
		}
		$this->settings=$data;
		view()->share('__settings',$this->settings);

	}
	function connect(){
		return view('backoffice.connect.index');
	}
	function login(){
		return view('backoffice.login');	
	}
	function analytic(){
		return view('backoffice.embed.analytic');	
	}
	function dashboard(){
		return view('backoffice.dashboard.index');	
	}
	function coupon($page='list',$couponid=''){
		if($page=='list'){
			return view('backoffice.coupon.list');	
		}elseif($page=='insert' || $page=='edit'){
			return view('backoffice.coupon.insert-edit',['page'=>$page,'couponid'=>$couponid]);	
		}	
	}
	function blog($page='list',$blogid=''){
		if($page=='list'){
			return view('backoffice.blog.list');	
		}elseif($page=='insert' || $page=='edit'){
			return view('backoffice.blog.insert-edit',['page'=>$page,'blogid'=>$blogid]);	
		}	
	}

	function faq($page='list',$faqid=''){
		if($page=='list'){
			return view('backoffice.faq.list');	
		}elseif($page=='insert' || $page=='edit'){
			return view('backoffice.faq.insert-edit',['page'=>$page,'faqid'=>$faqid]);	
		}	
	}
	function size_guide($page='list',$sizeguideid=''){
		if($page=='list'){
			return view('backoffice.size-guide.list');	
		}elseif($page=='insert' || $page=='edit'){
			return view('backoffice.size-guide.insert-edit',['page'=>$page,'sizeguideid'=>$sizeguideid]);	
		}	
	}
	function fabric_estimator($parentid='',$fecategoryid='',$page='list',$fabricestimatorid=''){
		if($page=='list'){
			return view('backoffice.fabric-estimator.list',['parentid'=>$parentid,'fecategoryid'=>$fecategoryid]);	
		}elseif($page=='insert' || $page=='edit'){
			return view('backoffice.fabric-estimator.insert-edit',['parentid'=>$parentid,'fecategoryid'=>$fecategoryid,'page'=>$page,'fabricestimatorid'=>$fabricestimatorid]);	
		}	
	}
	function fabric_estimator_category($page='list',$fecategoryid=''){
		if($page=='list'){
			return view('backoffice.fabric-estimator-category.list');	
		}elseif($page=='insert' || $page=='edit'){
			return view('backoffice.fabric-estimator-category.insert-edit',['page'=>$page,'fecategoryid'=>$fecategoryid]);	
		}	
	}
	function fabric_estimator_subcategory($parentid='',$page='list',$fecategoryid=''){
		if($page=='list'){
			return view('backoffice.fabric-estimator-category.list',['parentid'=>$parentid]);	
		}elseif($page=='insert' || $page=='edit'){
			return view('backoffice.fabric-estimator-category.insert-edit',['parentid'=>$parentid,'page'=>$page,'fecategoryid'=>$fecategoryid]);	
		}	
	}
	function transaction_history(){
		return view('backoffice.crm.transaction_history.index');	
			
	}
	function customer_loyalty(){
		return view('backoffice.crm.customer_loyalty.index');	
			
	}
	function mailing_list(){
		return view('backoffice.crm.mailing_list.index');	
			
	}

	function users($page='list',$userid=''){
		if($page=='list'){
			return view('backoffice.users.list');	
		}elseif($page=='insert' || $page=='edit'){
			return view('backoffice.users.insert-edit',['page'=>$page,'userid'=>$userid]);	
		}
	}
	function pasien($page='list',$pasienid=''){
		if($page=='list'){
			return view('backoffice.pasien.list');	
		}elseif($page=='insert' || $page=='edit'){
			return view('backoffice.pasien.insert-edit',['page'=>$page,'pasienid'=>$pasienid]);	
		}
	}
	function bidan($page='list',$bidanid=''){
		if($page=='list'){
			return view('backoffice.bidan.list');	
		}elseif($page=='insert' || $page=='edit'){
			return view('backoffice.bidan.insert-edit',['page'=>$page,'bidanid'=>$bidanid]);	
		}
	}
	function auto_response($page='list',$autoresponseid=''){
		if($page=='list'){
			return view('backoffice.auto-response.list');	
		}elseif($page=='insert' || $page=='edit'){
			return view('backoffice.auto-response.insert-edit',['page'=>$page,'autoresponseid'=>$autoresponseid]);	
		}
	}
	function schedule($page='list',$scheduleid=''){
		if($page=='list'){
			return view('backoffice.schedule.list');	
		}elseif($page=='insert' || $page=='edit'){
			return view('backoffice.schedule.insert-edit',['page'=>$page,'scheduleid'=>$scheduleid]);	
		}
	}
	
	function category($page='list',$categoryid=''){
		if($page=='list'){
			return view('backoffice.category.list');	
		}elseif($page=='insert' || $page=='edit'){
			return view('backoffice.category.insert-edit',['page'=>$page,'categoryid'=>$categoryid]);	
		}	
	}
	function meta($page='list',$metaid=''){
		if($page=='list'){
			return view('backoffice.meta.list');	
		}elseif($page=='insert' || $page=='edit'){
			return view('backoffice.meta.insert-edit',['page'=>$page,'metaid'=>$metaid]);	
		}	
	}

	function menu($page='list',$menuid=''){
		if($page=='list'){
			return view('backoffice.menu.list');	
		}elseif($page=='insert' || $page=='edit'){
			return view('backoffice.menu.insert-edit',['page'=>$page,'menuid'=>$menuid]);	
		}	
	}

	function submenu($menuid='',$page='list',$submenuid=''){
		if($page=='list'){
			return view('backoffice.submenu.list',['menuid'=>$menuid]);	
		}elseif($page=='insert' || $page=='edit'){
			return view('backoffice.submenu.insert-edit',['page'=>$page,'menuid'=>$menuid,'submenuid'=>$submenuid]);	
		}	
	}
	function collection($page='list',$collectionid=''){
		if($page=='list'){
			return view('backoffice.collection.list');	
		}elseif($page=='insert' || $page=='edit'){
			return view('backoffice.collection.insert-edit',['page'=>$page,'collectionid'=>$collectionid]);	
		}	
	}
	function push_notification($page='list',$notificationid=''){
		if($page=='list'){
			return view('backoffice.crm.push_notification.list');	
		}elseif($page=='insert' || $page=='edit'){
			return view('backoffice.crm.push_notification.insert-edit',['page'=>$page,'notificationid'=>$notificationid]);	
		}	
	}
	function blog_category(){
		return view('backoffice.blog-category.index');	
	}
	function lookbook($influencerid='',$page='list',$lookbookid=''){
		if($page=='list'){
			return view('backoffice.lookbook.lookbook.list',['influencerid'=>$influencerid]);	
		}elseif($page=='insert' || $page=='edit'){
			return view('backoffice.lookbook.lookbook.insert-edit',['page'=>$page,'influencerid'=>$influencerid,'lookbookid'=>$lookbookid]);	
		}
	}
	function influencer($page='list',$influencerid=''){
		if($page=='list'){
			return view('backoffice.lookbook.influencer.list');	
		}elseif($page=='insert' || $page=='edit'){
			return view('backoffice.lookbook.influencer.insert-edit',['page'=>$page,'influencerid'=>$influencerid]);	
		}
	}
	function contents($page,$loc2=''){
		return view('backoffice.contents.index',['loc'=>$page,'loc2'=>$loc2]);
			
	}
	function contents_setting(){
		return view('backoffice.contents.settings');			
	}
	function contents_popup(){
		return view('backoffice.contents.popup');	
	}
	function order($orderid=''){
		if(empty($orderid)){
			return view('backoffice.order.list');
		}else{
			return view('backoffice.order.detail',['orderid'=>$orderid]);
		}
	}
	function order_abandoned($orderid=''){
		if(empty($orderid)){
			return view('backoffice.order.abandoned.list');
		}else{
			return view('backoffice.order.abandoned.detail',['orderid'=>$orderid]);
		}
	}
	function master($page=''){
		switch ($page) {
			case 'state':
				return view('backoffice.master.state.index');	
				break;
			case 'province':
				return view('backoffice.master.province.index');	
				break;
			case 'city':
				return view('backoffice.master.city.index');	
				break;
			case 'district':
				return view('backoffice.master.district.index');	
				break;
			case 'customers':
				return view('backoffice.master.customers.index');	
				break;
			case 'users':
				return view('backoffice.master.users.index');	
				break;
			case 'payment_method':
				return view('backoffice.master.payment_method.index');	
				break;
			default:
				break;
		}
	}
	function customer_download(){
		$result = $this->call_api('customer/raw','POST')->result;
		$fileName = 'customer-'.date("Y-m-d His").'.csv';
		
		$headers = array(
		    "Content-type"        => "text/csv",
		    "Content-Disposition" => "attachment; filename=$fileName",
		    "Pragma"              => "no-cache",
		    "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
		    "Expires"             => "0"
		);
		$header=[];
		if(isset($result[0])){
			$header = array_keys((array)$result[0]);
		}
		$callback = function() use($result, $header) {
		    $file = fopen('php://output', 'w');
		    fputs($file,"sep=,\n");
		    fputcsv($file, $header);

		    foreach ($result as $row) {
		        fputcsv($file,array_values((array)$row));
		    }

		    fclose($file);
		};
// echo "string";
		return response()->stream($callback, 200, $headers);
	}
}
