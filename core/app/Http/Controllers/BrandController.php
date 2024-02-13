<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Brands';
        $data['table'] = Brand::all();
        return view('dashboard.brand',$data);
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
        try {
            Brand::create($request->all());
            return redirect()->back()->with('success','Brand Created');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::find($id);
        if(!$brand){
            return redirect()->back()->with('error','Brand Not Found');
        }
        $brand->update($request->all());
        return redirect()->back()->with('success','Brand Updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::find($id);
        if(!$brand){
            return redirect()->back()->with('error','Brand Not Found');
        }
        $brand->delete();
        return redirect()->back()->with('success','Brand Deleted');
    }
}
