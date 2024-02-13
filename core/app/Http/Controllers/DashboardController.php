<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $currentMonth = Carbon::now()->month;
        $lastMonth = $currentMonth - 1;
        if ($lastMonth < 1) {
            $lastMonth = 12; // Set to December
        }
        $lastSuccessTrx = Transaction::where('status',5)->whereMonth('created_at', $lastMonth)->sum('amount');
        $successTrxNow = Transaction::where('status',5)->whereMonth('created_at', $currentMonth)->sum('amount');
        $percentSuccessSale = $this->hitungPresentase($lastSuccessTrx,$successTrxNow);

        $lastRejectTrx = Transaction::where('status',3)->whereMonth('created_at', $lastMonth)->sum('amount');
        $RejectTrxNow = Transaction::where('status',3)->whereMonth('created_at', $currentMonth)->sum('amount');
      
        $percentRejectSale = $this->hitungPresentase($lastRejectTrx,$RejectTrxNow);
    
        $data['title'] =  'Dashboard';
        $data['info'] = [
            'sale' => $successTrxNow,
            'percentSale' => $percentSuccessSale,
            'percentSuccessInfo' => $percentSuccessSale >= 0 ?true:false,
            'reject' => $RejectTrxNow,
            'percentReject' => $percentRejectSale,
            'percentRejectInfo' => $percentRejectSale >= 0 ?true:false,
            'customer' => User::where('role','cust')->count(),
            'product' => Product::where('status','1')->count(),
        ];
        // dd($data);
        $data['table'] = Transaction::with('customers','details','details.product')->latest()->limit(10)->get();
        return view('dashboard.index',$data);
    }

    function hitungPresentase($last, $now) {
        // Pastikan tidak terjadi pembagian dengan nol
        if ($last != 0) {
            $percentageChange = (($now - $last) / abs($last)) * 100;
            return $percentageChange;
        } else {
            // Jika nilai terakhir adalah 0, kembalikan 0%
            if($now != 0){
                return 100;
            }else{
                return 0;
            }
        }
    }
}
