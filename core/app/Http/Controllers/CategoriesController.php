<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Categories';
        $data['table'] = Categories::all();
        return view('dashboard.categories',$data);
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
        $request->validate(['category_name'=>'required']);
        DB::beginTransaction();
        try {
            Categories::create([
                'category_name'=>$request->category_name,
                'category_slug' => Str::slug($request->category_name)
            ]);
            DB::commit();
            return redirect()->back()->with('success','New  Category Created');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error','Error: '.$th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $categories = Categories::find($id);
        if(!$categories){ 
            return redirect()->back()->with('error','Not Found');
        }
        $request->validate(['category_name'=>'required']);
        DB::beginTransaction();
        try {
            $categories->update([
                'category_name'=>$request->category_name,
                'category_slug' => Str::slug($request->category_name)
            ]);
            DB::commit();
            return redirect()->back()->with('success','Category Updated');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error','Error: '.$th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categories = Categories::find($id);
        if(!$categories){ 
            return redirect()->back()->with('error','Not Found');
        }
        DB::beginTransaction();
        try {
           $categories->delete();
            DB::commit();
            return redirect()->back()->with('success','Category Deleted');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error','Error: '.$th->getMessage());
        }
    }
}
