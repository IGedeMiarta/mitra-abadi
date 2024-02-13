<?php

namespace App\Http\Controllers;

use App\Exports\BrandExport;
use App\Exports\CategoryExport;
use App\Exports\CustomerExport;
use App\Exports\DiscountExport;
use App\Exports\ProudctExport;
use App\Exports\SellingExport;
use App\Models\Brand;
use App\Models\Categories;
use App\Models\Product;
use App\Models\ProductDiscount;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class ReportController extends Controller
{
    public function customer(){
        $data['title'] = 'Customer Report';
        $data['table'] = User::where('role','cust')->get();
        return view('dashboard.report.customer',$data);
    }
    public function sell(Request $request){
        $trx = Transaction::with('customers','details','details.product');
        switch ($request->filter) {
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
            case 'monthly':
                $title = 'Filter By ' . $request->filter;
                $startDate = Carbon::now()->startOfMonth()->startOfDay();
                $endDate = Carbon::now()->endOfMonth()->endOfDay();
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
        $data['title'] = 'Transaction ' .$title;
        $data['table']= $trx;
        return view('dashboard.report.sell',$data);
    }
    public function discount(){
        $data['title'] = 'Discount Report';
        $data['table'] =  ProductDiscount::with('product')->orderByDesc('id')->get();
        return view('dashboard.report.discount',$data);
    }
    public function product(){
        $data['title'] = 'Product Report';
        $data['table'] = Product::with(['category','brand'])->orderByDesc('id')->get();
        return view('dashboard.report.product',$data);
    }
    public function category(){
        $data['title'] = 'Category Report';
        $data['table'] = Categories::all();
        return view('dashboard.report.category',$data);
    }
    public function brand(){
        $data['title'] = 'Brand Report';
        $data['table'] = Brand::all();
        return view('dashboard.report.brand',$data);
    }
    public function exportPDF(Request $request,$type){
        switch ($type) {
        case 'customer':
            $data['table'] =  User::where('role','cust')->orderByDesc('id')->get();
            $data['title'] = 'Customer';
            return view('dashboard.report.pdf.customer', $data);
            break;

        case 'sell':
            
            $trx = Transaction::with('customers','details','details.product');
            switch ($request->filter) {
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
            return view('dashboard.report.pdf.sell', $data);
            break;
        case 'discount':
            $data['title'] = 'All Discount';
            $data['table'] =  ProductDiscount::with('product')->orderByDesc('id')->get();
            return view('dashboard.report.pdf.discount',$data);
            break;
        case 'product':
            $data['title'] = 'All Product';
            $data['table'] = Product::with(['category','brand'])->orderByDesc('id')->get();
            return view('dashboard.report.pdf.product',$data);
            break;
        case 'category':
            $data['title'] = 'All Category';
            $data['table'] = Categories::all();
            return view('dashboard.report.pdf.category',$data);
            break;
        case 'brand':
            $data['title'] = 'All Brand';
            $data['table'] = Brand::all();
            return view('dashboard.report.pdf.brand',$data);
            break;
        default:
            return redirect()->back()->with('error', 'Invalid action');
            break;
        }
    }

    public function exportExcel(Request $request,$type){
        switch ($type) {
            case 'customer':
                return Excel::download(new CustomerExport, 'AllCustomer.xlsx');
                break;
            case  'sell':
                return Excel::download(new SellingExport($request->filter),'ExportSelling.xlsx');
                break;
            case 'discount':
                return Excel::download(new DiscountExport,'AllDiscount.xlsx');
                break;
            case 'product':
                return Excel::download(new ProudctExport,'AllProduct.xlsx');
                break;
            case 'category':
                return Excel::download(new CategoryExport,'AllCategory.xlsx');
                break;
            case 'brand':
                return Excel::download(new BrandExport,'AllBrand.xlsx');
                break;
            default:
                return redirect()->back()->with('error', 'Invalid action');
                break;
        }
    }
}
