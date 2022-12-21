<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    public function index()
    {
        return view('laporan');
    }
    public function menu()
    {
        $menu = Http::get('http://tes-web.landa.id/intermediate/menu');
        $men = $menu->json();

        return view('laporan', compact('men'));
        
    }

    public function laporan(Request $request)
    {
        $tahun = $request->tahun;
        $laporan = Http::get('http://tes-web.landa.id/intermediate/transaksi?tahun='.$tahun);
        $laporan_pertahun = $laporan->json();

        $menu = Http::get('http://tes-web.landa.id/intermediate/menu');
        $men = $menu->json();

        foreach ($laporan_pertahun as $l) {           
            $laporan_perbulan[] = [
                'bulan' => date('m', strtotime($l['tanggal'])),
                'menu' => $l['menu'],
                'total' => $l['total'],
            ];
        }

        // for($i = 1; $i <= 12; $i++){
        //     $total_perbulan[] = [
        //         'bulan' => $i,
        //         'total' => 0,
        //     ];
        // }

        // foreach ($laporan_pertahun as $t) {           
        //     $total_perbulan[] = [
        //         'bulan' => date('m', strtotime($t['tanggal'])),
        //         'total' => $t['total'],
        //     ];
        // }

        // foreach ($total_perbulan as $b) {
        //     foreach ($laporan_pertahun as $t) {
        //         // echo $b['bulan']."<br>";
        //         $bulan = date("n", strtotime($t['tanggal']));
        //         if($bulan == $b['bulan']){
        //             $hasil = $b['total']+= $t['total'];
        //         }
        //     }
        // }
        // dd($total_perbulan);
        // echo $tot."<br>";
        // die();
        // dd($total_perbulan);
        // $total_perbulan = 0; 

        return view('laporan', compact('laporan_perbulan', 'men','tahun'));        
    }
}
