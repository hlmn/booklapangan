<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\customers;
use App\fasilitas;
use App\fasor;
use App\jenislap;
use App\lapangan;
use App\menawarkan;

use DB;

class FindController extends Controller
{
    public function CariFasor(Request $request)
    {
        $tgl = $request->input('tgl');
        $kota = $request->input('kota');
        $start = $request->input('start');
        $end = $request->input('end');
        $lapangan = $request->input('lapangan');
        $items = \App\jenislap::pluck('NAMA_JENIS_LAP','NAMA_JENIS_LAP');

       $terpakai = DB::select("select lapangan.ID_LAP from lapangan,transaksi,fasor where lapangan.ID_LAP=transaksi.ID_LAP and transaksi.tgl_main='$tgl' and (transaksi.JAM_MAIN<'$end' and transaksi.JAM_SELESAI>'$start') and lapangan.NAMA_JENIS_LAP='$lapangan' and fasor.KOTA_FASOR='$kota' and fasor.ID_FASOR=lapangan.ID_FASOR;");
       if ($terpakai == null){
        $terpakai ="1";
        $results = DB::select("select fasor.NAMA_FASOR, harga,fasor.ID_FASOR from fasor,lapangan where ID_LAP not in (select lapangan.ID_LAP from lapangan,transaksi,fasor where lapangan.ID_LAP=transaksi.ID_LAP and transaksi.tgl_main='$tgl' and (transaksi.JAM_MAIN<'$end' and transaksi.JAM_SELESAI>'$start') and lapangan.NAMA_JENIS_LAP='$lapangan' and fasor.KOTA_FASOR='$kota' and fasor.ID_FASOR=lapangan.ID_FASOR)and lapangan.ID_FASOR=fasor.ID_FASOR and lapangan.NAMA_JENIS_LAP='$lapangan' group by fasor.NAMA_FASOR;");
       
       // echo "select fasor.NAMA_FASOR, harga,fasor.ID_FASOR from fasor,lapangan where ID_LAP not in (select lapangan.ID_LAP from lapangan,transaksi,fasor where lapangan.ID_LAP=transaksi.ID_LAP and transaksi.tgl_main='$tgl' and (transaksi.JAM_MAIN<'$end' and transaksi.JAM_SELESAI>'$start') and lapangan.NAMA_JENIS_LAP='$lapangan' and fasor.KOTA_FASOR='$kota' and fasor.ID_FASOR=lapangan.ID_FASOR)and lapangan.ID_FASOR=fasor.ID_FASOR and lapangan.NAMA_JENIS_LAP='$lapangan' group by fasor.NAMA_FASOR;";
        return view('hasil',['tgl' => $tgl,'kota' => $kota,'start' => $start,'lapangan' => $lapangan,'results' => $results, 'items' => $items, 'end' => $end,'terpakai' => $terpakai]);
       }


        return view('hasil',['tgl' => $tgl,'kota' => $kota,'start' => $start,'lapangan' => $lapangan, 'items' => $items, 'end'=> $end,'terpakai' => $terpakai]);

    }

    public function Index()
    {
    	//$tests = \App\fasor::has('lapangan','>',3)->get();
        $items = \App\jenislap::pluck('NAMA_JENIS_LAP','NAMA_JENIS_LAP');
        return view('index',['items' => $items]);
	
    }
    public function ShowLap($id_fasor,$tgl,$start,$end)
    {   

        $fasilitas= DB::select("SELECT fasilitas.NAMA_FAS, menawarkan.ID_LAP FROM menawarkan,lapangan,fasilitas WHERE menawarkan.ID_LAP=lapangan.ID_LAP and menawarkan.ID_FAS=fasilitas.ID_FAS and lapangan.ID_FASOR='$id_fasor'"); 

        $nm_fsr= DB::select("SELECT DISTINCT fasor.NAMA_FASOR FROM fasor WHERE ID_FASOR='$id_fasor';");
        $show= DB::select("select lapangan.ID_LAP,lapangan.NAMA_LAP, lapangan.harga,lapangan.UKURAN_LAP,fasor.NAMA_FASOR,fasor.ID_FASOR from fasor,lapangan where ID_LAP not in (select lapangan.ID_LAP from lapangan,transaksi,fasor where lapangan.ID_LAP=transaksi.ID_LAP and transaksi.tgl_main='$tgl' and (transaksi.JAM_MAIN<'$end' and transaksi.JAM_SELESAI>'$start') and lapangan.NAMA_JENIS_LAP='Basket' and fasor.id_fasor='$id_fasor' and fasor.ID_FASOR=lapangan.ID_FASOR)and lapangan.ID_FASOR=fasor.ID_FASOR and lapangan.NAMA_JENIS_LAP='Basket' group by lapangan.NAMA_LAP;");
        
        return view('haslap',['shows' => $show,'fasilitas' => $fasilitas, 'nm_fsrs' => $nm_fsr, 'tgl' => $tgl, 'start' => $start, 'end' => $end]);
    }
}
