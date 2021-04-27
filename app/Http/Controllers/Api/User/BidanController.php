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
use App\Models\BidanPasien;
use App\Models\PasienProfile;
use App\Models\Kunjungan;
use App\Models\PemeriksaanFisik;
use App\Models\PemeriksaanLab;
class BidanController extends ApiController
{
	public function home(){
		$userid = $this->jwt_data['userdata']->id;
		$data = [
			'user'=>BidanProfile::firstWhere('bidanid',$userid),
			'totalPasien' => BidanPasien::where('bidanid',$userid)->count(),
			'totalPasienResikoTinggi' => BidanPasien::with('resiko')
											->whereHas('resiko',function($query){
												$query->where('resiko','tinggi');
											})->where('bidanid',$userid)->count(),
			'kunjunganHarian' => Kunjungan::where('bidanid',$userid)->where('date',date("Y-m-d"))->count(),
			'kunjunganBulanan' => Kunjungan::where('bidanid',$userid)
												->where(DB::raw('MONTH(date)'),date("m"))
												->where(DB::raw('YEAR(date)'),date("Y"))
												->count(),

		]; 
	}
	public function list_pasien(){
		$userid = $this->jwt_data['userdata']->id;
		$search = request()->input('search');
		$key	= request()->input('key');
		$result = BidanPasien::where('bidanid',$userid)
				->whereHas('pasienProfile',function($query)use($search){
					$query->where('nama','like',"%$search%")
							->where('nik','like',"%$search%");
				})
				->get()
				->sortByDesc('pasienProfile.nama');
		return response()->json(['status'=>1,'result'=>$result,'key'=>$key]);
	}
	public function add_pasien(){
		$userid = $this->jwt_data['userdata']->id;
		$email = request()->input('email');
		$nik = request()->input('nik');
		$user = User::with('pasienProfile')->has('pasienProfile')->where('email',$email);
		if(!$user->exists()){
			return response()->json(['status'=>0,'msg'=>'Email tidak ditemukan']);
		}

		if($user->pasienProfile->nik!=$nik){
			return response()->json(['status'=>0,'msg'=>'NIK salah']);
		}

		BidanPasien::insert([
			'bidanid'=>$userid,
			'pasienid'=>$user->id,
		]);

		return esponse()->json(['status'=>1]);
	}
	public function remove_pasien(){
		$userid = $this->jwt_data['userdata']->id;
		$pasienid = request()->input('pasienid');
		BidanPasien::where(['bidanid'=>$bidanid,'pasienid'=>$pasienid]);
	}
	public function add_kunjungan(){
		$userid = $this->jwt_data['userdata']->id;
		$pasienid = request()->input('pasienid');
		$date = request()->input('date');
		Kunjungan::insert([
			'bidanid'=>$userid,
			'pasienid'=>$pasienid,
			'date'=>$date
		]);
		return response()->json(['status'=>1]);
	}
	public function add_rujukan(){
		$userid = $this->jwt_data['userdata']->id;
		$pasienid = request()->input('pasienid');
		$faskesid = request()->input('faskesid');
		Rujukan::insert([
			'pasienid'=>$pasienid,
			'bidanid'=>$userid,
			'faskesid'=>$faskesid,
			'status'=>'new',
			'created_at'=>date("Y-m-d H:i:s")
		]);
	}
	public function get_profile(){
		$userid = $this->jwt_data['userdata']->id;
		$pasienid = request()->input('pasienid');
		if(BidanPasien::where(['bidanid'=>$userid,'pasienid'=>$pasienid])->exists()){
			return response()->json(['status'=>0,'msg'=>'Tidak ada akses']);
		}
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
		$pasienid = request()->input('pasienid');

		$pemeriksaanFisik = PemeriksaanFisik::where('bidanid',$userid)
								->where('date',$date)
								->where('pasienid',$pasienid)
								->orderBy('id','desc')->row();

		$pemeriksaanLab = PemeriksaanLab::where('bidanid',$userid)
								->where('date',$date)
								->where('pasienid',$pasienid)
								->orderBy('id','desc')->row();
		$chart = [];
		$data = [
			'chart'=>$chart,
			'date'=>$date,
			'pemeriksaanFisik'=>$pemeriksaanFisik,
			'pemeriksaanLab'=>$pemeriksaanLab,
		];
	}
	public function add_pemeriksaan_fisik(){

		$userid = $this->jwt_data['userdata']->id;
		$pasienid = request()->input('pasienid');
		$date = request()->input('date');
		$tb = request()->input('tb');
		$bb = request()->input('bb');
		$conjuctiva = request()->input('conjuctiva');
		$skelera = request()->input('skelera');
		$kelopak_mata = request()->input('kelopak_mata');
		$darah_hg = request()->input('darah_hg');
		$darah_hb = request()->input('darah_hb');
		$suhu = request()->input('suhu');
		$nadi = request()->input('nadi');
		$pernafasan = request()->input('pernafasan');
		$mulut = request()->input('mulut');
		$telinga = request()->input('telinga');
		$hidung = request()->input('hidung');
		$tenggorokan = request()->input('tenggorokan');
		$tinggi_fundus = request()->input('tinggi_fundus');
		$ballotement = request()->input('ballotement');
		$posisi_janin = request()->input('posisi_janin');
		$pergerakan_janin = request()->input('pergerakan_janin');
		$jantung_denyut = request()->input('jantung_denyut');
		$jantung_frekuensi = request()->input('jantung_frekuensi');
		$jantung_irama = request()->input('jantung_irama');
		$genitalia = request()->input('genitalia');
		$extermitas = request()->input('extermitas');

		$data = [
			'bidanid'	=> $userid,
			'pasienid'	=> $pasienid,
			'date'	=> $date,
			'tb'	=> $tb,
			'bb'	=> $bb,
			'conjuctiva'	=> $conjuctiva,
			'skelera'	=> $skelera,
			'kelopak_mata'	=> $kelopak_mata,
			'darah_hg'	=> $darah_hg,
			'darah_hb'	=> $darah_hb,
			'suhu'	=> $suhu,
			'nadi'	=> $nadi,
			'pernafasan'	=> $pernafasan,
			'mulut'	=> $mulut,
			'telinga'	=> $telinga,
			'hidung'	=> $hidung,
			'tenggorokan'	=> $tenggorokan,
			'tinggi_fundus'	=> $tinggi_fundus,
			'ballotement'	=> $ballotement,
			'posisi_janin'	=> $posisi_janin,
			'pergerakan_janin'	=> $pergerakan_janin,
			'jantung_denyut'	=> $jantung_denyut,
			'jantung_frekuensi'	=> $jantung_frekuensi,
			'jantung_irama'	=> $jantung_irama,
			'genitalia'	=> $genitalia,
			'extermitas'	=> $extermitas,
		];
		PemeriksaanFisik::insert($data);
		return response()->json(['status'=>1]);
	}
	public function add_pemeriksaan_lab(){
		$userid = $this->jwt_data['userdata']->id;
		$bidanid = request()->input('bidanid');
		$pasienid = request()->input('pasienid');
		$date = request()->input('date');
		$hemoglobin = request()->input('hemoglobin');
		$golongan_darah = request()->input('golongan_darah');
		$protein_urine = request()->input('protein_urine');
		$gula_darah = request()->input('gula_darah');
		$hepatitis_b = request()->input('hepatitis_b');
		$hiv = request()->input('hiv');
		$pms = request()->input('pms');
		$lainnya = request()->input('lainnya');
		$data = [
			'bidanid'	=> $bidanid,
			'pasienid'	=> $pasienid,
			'date'	=> $date,
			'hemoglobin'	=> $hemoglobin,
			'golongan_darah'	=> $golongan_darah,
			'protein_urine'	=> $protein_urine,
			'gula_darah'	=> $gula_darah,
			'hepatitis_b'	=> $hepatitis_b,
			'hiv'	=> $hiv,
			'pms'	=> $pms,
			'lainnya'	=> $lainnya,
		];

		PemeriksaanLab::insert($data);
		return response()->json(['status'=>1]);
	}
}
