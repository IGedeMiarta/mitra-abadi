<?php

namespace App\Exports;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SellingExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }
    
    public function view(): View
    {
        $trx = Transaction::with('customers','details','details.product');
        switch ($this->filter) {
            case 'daily':
                $title = 'Filter By Daily';
                $today = Carbon::now()->toDateString();
                $trx = $trx->whereDate('created_at', $today);
                break;
            case 'weekly':
                $title = 'Filter By Week';
                $startDate = Carbon::now()->subWeek()->startOfDay();
                $endDate = Carbon::now()->endOfDay();
                $trx = $trx->whereBetween('created_at', [$startDate, $endDate]);
                break;
            case 'year':
                $title = 'Filter By Year';
                $currentYear = Carbon::now()->year;
                $trx = $trx->whereYear('created_at', $currentYear);
                break;
            default:
                $title = 'All';
                break;
        }
        $trx = $trx->latest()->get();
        $data['title'] = 'Report Transaction ' .$title;
        $data['table']= $trx;
        return view('dashboard.report.excel.sell',$data);
    }
}
