<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Categories;
use App\Models\Product;
use App\Models\StockOpname;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;

class StockController extends Controller
{
    public function index(){
        $data['title'] = 'Stock';
        $data['table'] = Product::with(['category','brand'])->orderByDesc('id')->paginate(10);
        $data['editproducts'] = Product::all();
        $data['category'] = Categories::all();
        $data['brand'] = Brand::all();
        return view('dashboard.stock',$data);
    }

    public function getLog($id){
        $stock = StockOpname::where('product_id',$id)->orderByDesc('id')->limit(10)->get();
        $rs = '';
        foreach ($stock as $key => $value) {
            $by = User::find($value->trx_by);
            
            $rs .= '<tr >';
            $rs .='<td>'.$key+1 .'</td>';
            $rs .='<td>'.$value->type.'</td>';
            $rs .='<td>'.$value->start_stock.'</td>';
            $rs .='<td>'.$value->end_stock.'</td>';
            $rs .='<td>'.$value->note.'</td>';
            $rs .='<td>'.$by->name.'</td>';
            $rs .='<td>'. df($value->created_at) .'</td>';
            $rs .='</tr>';
        }
        return response()->json([
            'status'=>200,
            'massage'=>'Data Stock Log',
            'data'  => $stock,
            'table' => $rs
        ]);
    }
    public function updateStok(Request $request){
        $product = Product::find($request->product);
      
        if($request->type == '-' && $product->stock < ( $request->stock - 1)){
            return redirect()->back()->with('error','Stok Invalid');
        }
        DB::beginTransaction();
        try {
            $stock = new StockOpname();
            $stock->product_id  = $request->product;
            $stock->type        = $request->type;
            $stock->start_stock = $product->stock;

            if ($request->type == '+') {
                $stock->end_stock   = $product->stock + $request->stock;
                $product->stock      += $request->stock;
            }else{
                $stock->end_stock   = $product->stock - $request->stock;
                $product->stock      -= $request->stock;

            }
            $stock->trx_by  = auth()->user()->id;
            $stock->note    = $request->note;
            
            $stock->save();
            $product->save();
          

            DB::commit();
            return redirect()->back()->with('success','Stok Updated');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('success','Error: ' . $th->getMessage() );

        }
    }
}
