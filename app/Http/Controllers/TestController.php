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

    public function laporan(Request $request)
    {
        $tahun = $request->tahun;
        $laporan = Http::get('http://tes-web.landa.id/intermediate/transaksi?tahun='.$tahun);
        $laporan_pertahun = $laporan->json();

        $menu = Http::get('http://tes-web.landa.id/intermediate/menu');
        $men = $menu->json();


        // foreach ($men as $m) {    
        //     for ($i=0; $i < 10; $i++) { 
        //         $coba[$i] = $i;
        //     }       
        // }

        // foreach ($men as $m) {
        //     $menus[$i] = 0; 
        // }


        foreach ($laporan_pertahun as $l) {           
            $laporan_perbulan[] = [
                'tanggal' => $l['tanggal'],
                'bulan' => date('m', strtotime($l['tanggal'])),
                'menu' => $l['menu'],
                'total' => $l['total'],
            ];
        }


        foreach ($laporan_pertahun as $l) {
            for ($i = 1; $i <= 12; $i++) {
                $total[$i] = 0;
            }
        }

        foreach ($laporan_pertahun as $p) {
            $bulan = date('n', strtotime($p['tanggal']));
            $total[$bulan] += $p['total'];
        }

        $januari = $total[1];
        $februari = $total[2];
        $maret = $total[3];
        $april = $total[4];
        $mei = $total[5];
        $juni = $total[6];
        $juli = $total[7];
        $agustus = $total[8];
        $september = $total[9];
        $oktober = $total[10];
        $november = $total[11];
        $desember = $total[12];

        // dd($men[0]);

        return view('laporan', compact('laporan_perbulan', 'men','tahun', 'januari', 'februari', 'maret','april','mei','juni','juli','agustus','september', 'oktober', 'november', 'desember'));        
    }
}
