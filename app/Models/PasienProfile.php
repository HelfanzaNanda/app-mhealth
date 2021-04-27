<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasienProfile extends Model
{
    protected $table = 'pasien_profile';
    public $timestamps = false;
    // public $appends=['resiko','nilai_resiko'];
    public function user(){
    	return $this->hasOne('App\Models\User','id','pasienid');
    }
    public function riwayatKehamilan(){
    	return $this->hasOne('App\Models\PasienRiwayatKehamilan','pasienid');
    }
    public function riwayatKesehatan(){
    	return $this->hasOne('App\Models\PasienRiwayatKesehatan','pasienid');
    }
    public function riwayatSosial(){
    	return $this->hasOne('App\Models\PasienRiwayatSosial','pasienid');
    }
    public function diaryKehamilan(){
    	return $this->hasOne('App\Models\PasienDiaryKehamilan','pasienid');
    }
    public function kehamilan(){
        return $this->hasOne('App\Models\PasienKehamilan','pasienid');
    }
    public function pemeriksaanFisik(){
        return $this->hasOne('App\Models\PemeriksaanFisik','pasienid');
    }

    public function kelurahan(){
        return $this->hasOne('App\Models\Kelurahan','kelurahanId','kelurahanid');
    }
    public function kecamatan(){
        return $this->hasOne('App\Models\Kecamatan','kecamatanId','kecamatanid');
    }
    public function kabupaten(){
        return $this->hasOne('App\Models\Kabupaten','kabupatenId','kabupatenid');
    } 
    public function provinsi(){
        return $this->hasOne('App\Models\Provinsi','provinsiId','provinsiid');
    }
    public function scopeWithAddress($query){
        return $query->with('kelurahan','kecamatan','kabupaten','provinsi');
    }
    // public function getResikoAttribute(){
    //     $tahun = (int)date('Y');
    //     $usia = $tahun - (int)date('Y',strtotime($this->tanggallahir));
    //     $tanggalpernikahan = $this->tanggalpernikahan;
    //     $jumlahanak = $this->jumlahanak;
    //     $hamil_pertama = $this->riwayatKehamilan()->orderBy('tanggal','asc')->first();
    //     $hamil_terakhir = $this->riwayatKehamilan()->orderBy('tanggal','desc')->first();

    //     $gagal_hamil = $this->riwayatKehamilan->where('kematian',1)->count();
    //     $pemeriksaan_fisik = $this->pemeriksaanFisik()->orderBy('date','desc')->first();
        
    //     $melahirkan_tarikan_vakum = $this->riwayatKehamilan->where('melahirkan_tarikan_vakum',1)->count();
    //     $melahirkan_uri_dirogoh = $this->riwayatKehamilan->where('melahirkan_uri_dirogoh',1)->count();
    //     $melahirkan_infus = $this->riwayatKehamilan->where('melahirkan_infus',1)->count();
    //     $melahirkan_sesar = $this->riwayatKehamilan->where('melahirkan_sesar',1)->count();

    //     $skor['melahirkan_tarikan_vakum'] = ($melahirkan_tarikan_vakum>0)?4:0;
    //     $skor['melahirkan_uri_dirogoh'] = ($melahirkan_uri_dirogoh>0)?4:0;
    //     $skor['melahirkan_infus'] = ($melahirkan_infus>0)?4:0;
    //     $skor['melahirkan_sesar'] = ($melahirkan_sesar>0)?8:0;


    //     $penyakit_kurang_darah = $this->riwayatKesehatan->where('kurang_darah',1)->count();
    //     $penyakit_malaria = $this->riwayatKesehatan->where('malaria',1)->count();
    //     $penyakit_tbc = $this->riwayatKesehatan->where('tbc',1)->count();
    //     $penyakit_jantung = $this->riwayatKesehatan->where('jantung',1)->count();
    //     $penyakit_diabetes = $this->riwayatKesehatan->where('diabetes',1)->count();
    //     $penyakit_seksual_menular = $this->riwayatKesehatan->where('seksual_menular',1)->count();


    //     $skor['penyakit_kurang_darah'] = ($penyakit_kurang_darah>0)?4:0;
    //     $skor['penyakit_malaria'] = ($penyakit_malaria>0)?4:0;
    //     $skor['penyakit_tbc'] = ($penyakit_tbc>0)?4:0;
    //     $skor['penyakit_jantung'] = ($penyakit_jantung>0)?4:0;
    //     $skor['penyakit_diabetes'] = ($penyakit_diabetes>0)?4:0;
    //     $skor['penyakit_seksual_menular'] = ($penyakit_seksual_menular>0)?4:0;




    //     $fisik_bengkak_pada_muka = $pemeriksaan_fisik->bengkak_pada_muka;
    //     $fisik_tekanan_darah_tinggi = $pemeriksaan_fisik->tekanan_darah_tinggi;
    //     $fisik_hydramnion = $pemeriksaan_fisik->hydramnion;
    //     $fisik_letak_sunsang = $pemeriksaan_fisik->letak_sunsang;
    //     $fisik_letak_lintang = $pemeriksaan_fisik->letak_lintang;

    //     $skor['fisik_bengkak_pada_muka'] = ($fisik_bengkak_pada_muka>0)?4:0;
    //     $skor['fisik_tekanan_darah_tinggi'] = ($fisik_tekanan_darah_tinggi>0)?4:0;
    //     $skor['fisik_hydramnion'] = ($fisik_hydramnion>0)?4:0;
    //     $skor['fisik_letak_sunsang'] = ($fisik_letak_sunsang>0)?4:0;
    //     $skor['fisik_letak_lintang'] = ($fisik_letak_lintang>0)?4:0;

    //     $kehamilan_kembar = $this->kehamilan->kembar;
    //     $kehamilan_keguguran = $this->kehamilan->keguguran;
    //     $kehamilan_usia = $this->kehamilan->usia_kehamilan;
    //     $kehamilan_pendarahan = $this->kehamilan->pendarahan;
    //     $kehamilan_preklamsia = $this->kehamilan->preklamsia;
        
    //     $skor['kehamilan_kembar'] = ($kehamilan_kembar>0)?4:0;
    //     $skor['kehamilan_keguguran'] = ($kehamilan_keguguran>0)?4:0;
    //     $skor['kehamilan_usia'] = ($kehamilan_usia>0)?4:0;
    //     $skor['kehamilan_pendarahan'] = ($kehamilan_pendarahan>0)?4:0;
    //     $skor['kehamilan_preklamsia'] = ($kehamilan_preklamsia>0)?4:0;


    //     $kehamilan_tanggal = $this->kehamilan->tanggalkehamilan;        
    //     $tb = $pemeriksaan_fisik->tb;

    //     $usia_hamil_1 = (strtotime($hamil_pertama->tanggal) - strtotime($tanggallahir));
    //     $usia_pernikahan_hamil_1 = (strtotime($hamil_pertama->tanggal) - strtotime($tanggalpernikahan));
    //     $jarak_hamil_terakhir = (strtotime($hamil_terakhir->tanggal) - strtotime($kehamilan_tanggal));
    //     $selisih_hamil_terakhir = (strtotime($kehamilan_tanggal)-strtotime($hamil_terakhir->tanggal));



    //     return [
    //         'skor_usia_saat_hamil'=>$skor_usia_saat_hamil,
    //     ];
    // }
    // public function getNilaiResikoAttribute(){
        
    //     if($usia<16 || $usia>35){

    //     }
    // }
}
