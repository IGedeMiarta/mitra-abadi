<?php

namespace App\Exports;

use App\Models\Brand;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class BrandExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
     public function view(): View
    {
        $data['table'] =  Brand::all();
        return view('dashboard.report.excel.brand',$data);
    }
}
