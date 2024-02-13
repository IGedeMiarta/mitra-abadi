<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Settings;
use App\Models\StockOpname;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\UserChart;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;
use Illuminate\Support\Str;


class TransactionController extends Controller
{
    public function chart(){
        $data['chart'] = UserChart::with('product','product.brand','product.category')->where('user_id',Auth::id())->get();
        // dd($data);
        return view('home.chart',$data);
    }
    public function chartAdd(Request $request){
        $product = Product::where('product_slug',$request->product)->first();
        if($product->stock == 0){
            return redirect()->back()->with('error','Out Of Stock');
        }
        $price = $request->_xcode / 111111;
        if(!$product){
            return redirect()->back()->with('error','Product Not Found');
        }
        $checkAlredry = UserChart::where(['product_id'=>$product->id,'user_id'=>auth()->user()->id])->first();
        if($checkAlredry){
            if($product->stock - ($checkAlredry->qty + 1) <= 0 ){
                return redirect()->back()->with('error','Out Of Stock');
            }
            $checkAlredry->qty += 1;
            $checkAlredry->save();
            return redirect()->back()->with('success','Product added to chart');
        }
        DB::beginTransaction();
        try {
            UserChart::create([
                'user_id'       => auth()->user()->id,
                'product_id'    => $product->id,
                'price'         => $price,
                'qty'           => 1,
                'sum'           => $price
            ]);
            DB::commit();
            return redirect()->back()->with('success','Product added to chart');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }
    }
    public function chartDel($id){
        $chart = UserChart::find($id);
        $chart->delete();
        return redirect()->back()->with('success','Product in chart deleted');
    }
    public function chartDelAll(){
        UserChart::where('user_id',auth()->user()->id)->delete();
        return redirect()->back()->with('success','All chart deleted');
    }

    public function trasaction(Request $request){
        $user = auth()->user();
        $products = $request->input('product');
        $prices = $request->input('price');
        $qtys = $request->input('qty');
        $totals = $request->input('total');
        DB::beginTransaction();
        $inv = Inv();
        try {
            $createOrder = new Transaction();
            $createOrder->Invoice = $inv;
            $createOrder->customer = auth()->user()->id;
            $createOrder->amount = $request->amount;
            $createOrder->status = 1;
            $createOrder->dp = 0;
            $createOrder->save();

         

            $text = '_Automatic Text From *'.appSettings('APP','APP_NAME').'*_' .enter(2);
            $text .= 'Hi *'.$user->name.'*'.enter();
            $text .= 'Your have new transaction: *'.$inv.'*'.enter(2);
            $text .= '------------------------------------------------------------' .enter();
            foreach ($products as $key => $p) {
               
                $prod = Product::find($p);
            
                $text  .='#'.$qtys[$key].'    -    '. $prod->product_name .'    _*'.num($totals[$key]).'*_' .enter();
                $qty = (int)$qtys[$key];
               
                
                $orderDetail = new TransactionDetail();
                $orderDetail->transaction_id	 = $createOrder->id;
                $orderDetail->product_id = $p;
                $orderDetail->qty = $qty;
                $orderDetail->price = $prices[$key];
                $orderDetail->total = $totals[$key];
                $orderDetail->save();

                $stock = new StockOpname();
                $stock->product_id  = $p;
                $stock->type        = "-";
                $stock->start_stock = $prod->stock;
                $stock->end_stock   = $prod->stock - $qty;
                $stock->trx_by  = auth()->user()->id;
                $stock->note    = 'Transaction INV : ' . $inv;
                $stock->save();

                $prod->stock      -= $qty;
                $prod->save();
            }
            $text .= '------------------------------------------------------------' .enter();
            $text .= 'Total: *'.num($request->amount).'*' .enter(2);
            $text .= '------------------------------------------------------------' .enter();

            $text .= '_for more details, please check link below_'.enter();
            $text .= '_'.url('invoice/'.$inv).'_';

            sendWA($text,$user->phone);
            DB::commit();
            UserChart::where('user_id',auth()->user()->id)->delete();
            return redirect()->intended('invoice/'.$createOrder->Invoice);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }
    }
    public function invoiceAll(){
        $data['title'] = 'Invoice';
        $data['table'] = Transaction::with('details','details.product')->where('customer',auth()->user()->id)->orderBy('status','ASC')->orderBy('id','desc')->limit(5)->get();


        // dd($data);
        return view('home.invoice',$data);
    }

    public function invoice($inv){
        $order = Transaction::with('customers','details','details.product')->where('Invoice',$inv)->first();
        // dd($order);
        if(!$order){
            return redirect()->back()->with('error','Inoice not found');
        }
        $data['title'] = 'Invoice: #'.$order->Invoice;
        $data['order'] = $order;
        return view('home.invoice-detail',$data);
    }
    public function adminView(Request $request){
        $trx = Transaction::with('customers','details','details.product');
        if($request->filter){
           
            //switch case
            switch ($request->filter) {
                case 'daily':
                    $title = 'Filter By '. $request->filter;
                    $today = Carbon::now()->toDateString();
                    $trx = $trx->whereDate('created_at', $today);
                    break;
                case 'weekly':
                    $title = 'Filter By '. $request->filter;
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
                    $title = 'Filter By '. $request->filter;
                    $currentYear = Carbon::now()->year;
                    $trx = $trx->whereYear('created_at', $currentYear);
                    break;
                default:
                    $title = 'No Filter';
                    break;
            }
        }else{
            $title = 'List';
        }
        $trx = $trx->latest()->get();
        $data['title'] = 'Transaction ' .$title;
        $data['table']= $trx;
        return view('dashboard.transaction',$data);
    }
    public function adminUpdate(Request $request, $id){
        $dp = $request->dp?? 0;
        $trx = Transaction::find($id);
        if(!$trx){
            return redirect()->back()->with('error','Transaction not found');
        }
        $trx->update([
            'info' => $request->info,
            'dp'    => intval(preg_replace('/[^\d.]/', '', $dp)),
            'status' => $request->status,
            'shipment'=> $request->shipment,
        ]);
        return redirect()->back()->with('success','Transaction updated');

    }
    public function uploadImage(Request $request, $id){
        $trx = Transaction::find($id);
        if(!$trx){
            return redirect()->back()->with('error','Trasaction Not Found');
        }
        $foto = $request->file('foto');
        $name = Str::slug($trx->Invoice);
        $fotoImg= strtolower($name).'.'.$foto->getClientOriginalExtension();
        $path = 'assets/images/trx/';
        $foto->move($path, $fotoImg);
        $imagesMain = $path.$fotoImg;
        if($trx->trx_img_1 === null){
            $trx->trx_img_1 = $imagesMain;
        }else{
            $trx->trx_img_2 = $imagesMain;
        }
        $trx->save();

        return redirect()->back()->with('success','Trasaction Images Saved');

    }
}
