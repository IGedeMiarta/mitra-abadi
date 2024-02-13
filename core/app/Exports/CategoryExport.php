<?php

namespace App\Exports;

use App\Models\Categories;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CategoryExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
     public function view(): View
    {
        $data['table'] =  Categories::all();
        return view('dashboard.report.excel.category',$data);
    }
}
