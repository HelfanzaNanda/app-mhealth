<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;

use GuzzleHttp\Client;
use ReallySimpleJWT\Token;
use Exception;
use Request;
use DB;
use Cache;
use App\Models\User;
use App\Models\BidanProfile;
use App\Models\PasienProfile;
use App\Models\ResikoPasien;
use App\Models\PemeriksaanFisik;
use App\Models\PemeriksaanLab;
use App\Models\PasienDiaryKehamilan;
use App\Models\PasienRiwayatKehamilan;
use App\Models\PasienRiwayatKesehatan;
use App\Models\PasienRiwayatSosial;
use App\Models\PasienKehamilan;
use App\Models\PromosiKesehatan;
use App\Models\Notifikasi;
class PasienController extends ApiController
{
	public function home(){
		$userid = $this->jwt_data['userdata']->id;
		$user = PasienProfile::firstWhere('pasienid',$userid);
		$resiko = Resiko::firstWhere('pasienid',$userid);
		$promosiKesehatan = PromosiKesehatan::orderBy('date','DESC')->limit(3)->get();
		$notif = Notifikasi::where('userid',$userid)->where('status','sent')->get();

		$data = [
			'user'=>$user,
			'resiko'=>$resiko,
			'promosiKesehatan'=>$promosiKesehatan,
			'notif'=>$notif
		];
		return response()->json(['status'=>1,'result'=>$data]);
	}
	public function notificcation_read(){
		$userid = $this->jwt_data['userdata']->id;
		$id = request()->input('id');
		Notifikasi::where(['userid'=>$userid,'id'=>$id])->delete();

		return response()->json(['status'=>1]);
	}
	public function post_diary(){
		$userid = $this->jwt_data['userdata']->id;
		$info1=request()->input('info1');
		$info2=request()->input('info2');
		$info3=request()->input('info3');
		$info4=request()->input('info4');

		if(!PasienDiaryKehamilan::where(['info1'=>$info1,'info2'=>$info2,'info3'=>$info3,'info4'=>$info4,'pasienid'=>$userid])->exists()){
			$data = [
				'created_at'=>date("Y-m-d H:i:s"),
				'pasienid'=>$userid,
				'info1'=>$info1,
				'info2'=>$info2,
				'info3'=>$info3,
				'info4'=>$info4,
			];
			PasienDiaryKehamilan::insert($data);
		}
		return response()->json(['status'=>1]);
	}
	public function get_pendidikan_kesehatan(){
		$userid = $this->jwt_data['userdata']->id;
		$limit = request()->input('limit');
		$category = request()->input('category');
		$list = PromosiKesehatan::where(function($query)use($category){
			if(!empty($category)){
				$query->where('category',$category);
			}
		})
		->orderBy('created_at','DESC')
		->limit($limit)
		->get();
		return response()->json(['status'=>1,'result'=>$list]);
	}
	public function get_pendidikan_kesehatan_detail($id){
		$data = PromosiKesehatan::firstWhere('id',$id);
		return response()->json(['status'=>1,'result'=>$data]);
	}


	public function get_profile(){
		$userid = $this->jwt_data['userdata']->id;
		$profile = PasienProfile::with('riwayatKehamilan',
										'riwayatKesehatan',
										'riwayatSosial',
										'kehamilan',
										'diaryKehamilan')
					->where('pasienid',$userid)->first();

		return response()->json(['status'=>1,'result'=>$profile]);
	}
	public function get_riwayat_pemeriksaan(){
		$userid = $this->jwt_data['userdata']->id;
		$date = request()->input('date');
		$pemeriksaanFisik = PemeriksaanFisik::where('pasienid',$userid)->where('date',$date)->orderBy('id','desc')->row();
		$pemeriksaanLab = PemeriksaanLab::where('pasienid',$userid)->where('date',$date)->orderBy('id','desc')->row();
		$chart = [];
		$data = [
			'chart'=>$chart,
			'date'=>$date,
			'pemeriksaanFisik'=>$pemeriksaanFisik,
			'pemeriksaanLab'=>$pemeriksaanLab,
		];
	}

	public function add_riwayat_kehamilan(){
		$userid = $this->jwt_data['userdata']->id;
		$tanggal = request()->input('tanggal');
		$tempat = request()->input('tempat');
		$penolong = request()->input('penolong');
		$lama = request()->input('lama');
		$jenis = request()->input('jenis');
		$usia = request()->input('usia');
		$komplikasi = request()->input('komplikasi');
		$kondisi_anak = request()->input('kondisi_anak');
		$bb_anak = request()->input('bb_anak');
		$lama_menyusui_eksklusif = request()->input('lama_menyusui_eksklusif');
		$kematian = request()->input('kematian');

		$data = [
			'pasienid'=>$userid,
			'tanggal'=>$tanggal,
			'tempat'=>$tempat,
			'penolong'=>$penolong,
			'lama'=>$lama,
			'jenis'=>$jenis,
			'usia'=>$usia,
			'komplikasi'=>$komplikasi,
			'kondisi_anak'=>$kondisi_anak,
			'bb_anak'=>$bb_anak,
			'lama_menyusui_eksklusif'=>$lama_menyusui_eksklusif,
			'kematian'=>$kematian
		];	
		PasienRiwayatKehamilan::insert($data);
		return response()->json(['status'=>1]);

	}
	public function remove_riwayat_kehamilan(){
		$userid = $this->jwt_data['userdata']->id;
		$id = request()->input('id');
		PasienRiwayatKehamilan::where('id',$id)->delete(); 
		return response()->json(['status'=>1]);
	}



	public function save_kehamilan(){
		$userid = $this->jwt_data['userdata']->id;
		$kehamilan = request()->input('kehamilan');
		$tanggal_haid_terakhir = request()->input('tanggal_haid_terakhir');
		$siklus_haid = request()->input('siklus_haid');
		$pendarahan = request()->input('pendarahan');
		$keputihan = request()->input('keputihan');
		$keputihan_warna = request()->input('keputihan_warna');
		$mual = request()->input('mual');
		$keluhan_lainnya = request()->input('keluhan_lainnya');

		$data = [
			'pasienid'=>$userid,
			'kehamilan'=>$kehamilan,
			'tanggal_haid_terakhir'=>$tanggal_haid_terakhir,
			'siklus_haid'=>$siklus_haid,
			'pendarahan'=>$pendarahan,
			'keputihan'=>$keputihan,
			'keputihan_warna'=>$keputihan_warna,
			'mual'=>$mual,
			'keluhan_lainnya'=>$keluhan_lainnya,
			
		];	
		if(PasienKehamilan::where('pasienid',$userid)->exists()){
			PasienKehamilan::where('pasienid',$userid)->update($data);
		}else{
			PasienKehamilan::insert($data);
		}
		return response()->json(['status'=>1]);

	}

	public function save_riwayat_kesehatan(){
		$userid = $this->jwt_data['userdata']->id;
		$keluhan = request()->input('keluhan');
		$riwayat_penyakit = request()->input('riwayat_penyakit');
		$riwayat_penyakit_suami = request()->input('riwayat_penyakit_suami');
		$riwayat_kdrt = request()->input('riwayat_kdrt');

		$data = [
			'pasienid'=>$userid,
			'keluhan'=>$keluhan,
			'riwayat_penyakit'=>$riwayat_penyakit,
			'riwayat_penyakit_suami'=>$riwayat_penyakit_suami,
			'riwayat_kdrt'=>$riwayat_kdrt,
			
		];	
		if(PasienRiwayatKesehatan::where('pasienid',$userid)->exists()){
			PasienRiwayatKesehatan::where('pasienid',$userid)->update($data);
		}else{
			PasienRiwayatKesehatan::insert($data);
		}
		return response()->json(['status'=>1]);

	}

	public function save_riwayat_sosial(){
		$userid = $this->jwt_data['userdata']->id;
		$usia_menikah = request()->input('usia_menikah');
		$perkawinan_ke = request()->input('perkawinan_ke');
		$merokok = request()->input('merokok');
		$alkohol = request()->input('alkohol');
		$narkoba = request()->input('narkoba');
		$hiv = request()->input('hiv');
		$pencegahan_malaria = request()->input('pencegahan_malaria');
		$riwayat_imunisasi = request()->input('riwayat_imunisasi');
		$riwayat_penyakit = request()->input('riwayat_penyakit');
		$gerakan_janin = request()->input('gerakan_janin');

		$data = [
			'pasienid'=>$userid,
			'usia_menikah'=>$usia_menikah,
			'perkawinan_ke'=>$perkawinan_ke,
			'merokok'=>$merokok,
			'alkohol'=>$alkohol,
			'narkoba'=>$narkoba,
			'hiv'=>$hiv,
			'pencegahan_malaria'=>$pencegahan_malaria,
			'riwayat_imunisasi'=>$riwayat_imunisasi,
			'riwayat_penyakit'=>$riwayat_penyakit,
			'gerakan_janin'=>$gerakan_janin,
			
		];	
		if(PasienRiwayatSosial::where('pasienid',$userid)->exists()){
			PasienRiwayatSosial::where('pasienid',$userid)->update($data);
		}else{
			PasienRiwayatSosial::insert($data);
		}
		return response()->json(['status'=>1]);

	}

}
