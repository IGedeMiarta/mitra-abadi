<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDiscount;
use App\Models\SpecialProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecialProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Discount Produk';
        $data['products'] = DB::table('products')
                ->leftJoin('product_discounts', 'products.id', '=', 'product_discounts.id_product')
                ->whereNull('product_discounts.id_product')
                ->select('products.*')
                ->get();
        $data['editproducts'] = DB::table('products')
                ->get();
        $data['table'] = ProductDiscount::with('product')->orderByDesc('status')->get();
        return view('dashboard.special',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $disc =  intval(preg_replace('/[^\d.]/', '', $request->disc));
            $finn =  intval(preg_replace('/[^\d.]/', '', $request->final));
            ProductDiscount::create([
                'id_product'    => $request->product,
                'disc'          => $disc,
                'final_amount'  => $finn
            ]);
            DB::commit();
            return redirect()->back()->with('success','Special Product Created');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductDiscount $specialProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductDiscount $specialProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductDiscount $specialProduct)
    {
        $specialProduct->update([
            'disc'          => $request->disc,
            'final_amount'  => intval(preg_replace('/[^\d.]/', '', $request->final)),
            'status'        => $request->status
        ]);
        return redirect()->back()->with('success','Special Product Created');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductDiscount $specialProduct)
    {
       
        $specialProduct->delete();
        return redirect()->back()->with('success','Special Product Deleted');

    }
}
