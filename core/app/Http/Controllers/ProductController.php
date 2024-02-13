<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Brand;
use App\Models\Categories;
use App\Models\Media;
use App\Models\Product;
use App\Models\StockOpname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['title'] = 'Product';
        $data['table'] = Product::with(['category','brand'])->orderByDesc('id')->get();
        // dd($data);
        $data['category'] = Categories::all();
        $data['brand'] = Brand::all();
        return view('dashboard.products',$data);
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
        $validator = Validator::make($request->all(),[
            'product_name'  => 'required',
            'category'      => 'required',
            'price'         => 'required',
            'in_size'       => 'required',
            'out_size'      => 'required',
            'weight'        => 'required',
            'description'   => 'required',
            'image'        => 'required',
            'brand'      => 'required',
            'stock'      => 'required',
        ]);

        if ($validator->fails()) {
            // dd($validator);
            return redirect()->back()->withErrors($validator)->with('createFailed', true);
        }
      
        DB::beginTransaction();
        try {
            $foto = $request->file('image');
            $name = Str::slug($request->product_name);
            $fotoImg= strtolower($name).'.'.$foto->getClientOriginalExtension();
            $path = 'assets/images/product/';
            $foto->move($path, $fotoImg);
            $imagesMain = $path.$fotoImg;

            $product =  Product::create([
                'product_name'  => $request->product_name,
                'product_slug'  => Str::slug($request->product_name),
                'id_category'   => $request->category,
                'price'         => intval(preg_replace('/[^\d.]/', '', $request->price)),
                'in_size'       => $request->in_size,
                'out_size'      => $request->out_size,
                'weight'        => intval(preg_replace('/[^\d.]/', '', $request->weight)),
                'description'   => $request->description,
                'images'        => $imagesMain,
                'brand_id'      => $request->brand,
                'stock'        => intval(preg_replace('/[^\d.]/', '', $request->stock)),
            ]);
            StockOpname::create([
                'product_id'    => $product->id,
                'type'          => '+',
                'start_stock'   => 0,
                'end_stock'     => intval(preg_replace('/[^\d.]/', '', $request->stock)),
                'trx_by'        => auth()->user()->id,
                'notes'         => 'Create product & first stock',
            ]);
            DB::commit();
            return redirect()->back()->with('success','Product Created');
        } catch (\Throwable $th) {
          
            DB::rollBack();
            dd($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if(!$product){
            return redirect()->back()->with('error','Product Not Found');
        }
        DB::beginTransaction();
        try {
            $foto = $request->file('foto');
            if($foto){
                $name = Str::slug($request->product_name);
                $fotoImg= strtolower($name).'.'.$foto->getClientOriginalExtension();
                $path = 'assets/images/product/';
                $foto->move($path, $fotoImg);
                $imagesMain = $path.$fotoImg;
            }else{
                $imagesMain = $product->images;
            }

            $product->update([
                'product_name'  => $request->product_name,
                'product_slug'  => Str::slug($request->product_name),
                'id_category'   => $request->category,
                'price'         => intval(preg_replace('/[^\d.]/', '', $request->price)),
                'in_size'       => $request->in_size,
                'out_size'      => $request->out_size,
                'weight'        => intval(preg_replace('/[^\d.]/', '', $request->weight)),
                'description'   => $request->description,
                'images'        => $imagesMain,
                'brand_id'      => $request->brand,
                'status'        => $request->status
            ]);
            DB::commit();
            return redirect()->back()->with('success','Product Updated');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back()->with('success','Product Deleted');
    }
}
