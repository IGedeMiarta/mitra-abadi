<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Product;
use App\Models\UserChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
  
    public function chartQty(Request $request,$id){
       
        $chart  = UserChart::find($id);
        if(!$chart){
            return response()->json([
                'status' => 404,
                'message' => 'Infalid User Chart',
            ]);
        }
        DB::beginTransaction();
        try {
           $chart->update(['qty'=>$request->qty]);
           DB::commit();
            return response()->json([
                'status' => 201,
                'message' => 'Chart Qty Updated',
                'data'  => $chart
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Error',
                'errors'  => $th->getMessage()
            ]);
        }

    }
    
    public function media($id)
    {
        // $product = Product::with('category')->find($id);
        // if(!$product){
        //     return response()->json(['status'=>404,'message'=>'Product Not Foound']);
        // }
        // $media = Media::where('slug',$product->product_slug)->orderByDesc('id')->get();
        // $medias=[];
        // foreach($media as $m){
        //     $medias[] = url($m->file);
        // }
        return response()->json([
            'status'    => 200,
            'message'   => 'Product By Id',
            'data'      => [
                'product'   => null,
                'media'     => null
            ]
        ]);

    }
    public function chart($id){
        $chart = UserChart::where('user_id',$id)->count();
        return response()->json([
            'status'    => 200,
            'message'   => 'Product By Id',
            'count'     => $chart??0,
            'data'      => []
        ]);
    }
   
}
