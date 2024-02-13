<?php

namespace App\Exports;

use App\Models\ProductDiscount;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class DiscountExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $data['table'] =  ProductDiscount::with('product')->orderByDesc('id')->get();
        return view('dashboard.report.excel.discount',$data);
    }
}
