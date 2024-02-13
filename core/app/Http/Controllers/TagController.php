<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Tags';
        $data['table'] = Tags::all();
        return view('dashboard.tags',$data);
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
        $request->validate(['name'=>'required']);
        DB::beginTransaction();
        try {
            Tags::create([
                'tag_name'=>strtolower($request->name)
            ]);
            DB::commit();
            return redirect()->back()->with('success','New  Tags Created');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error','Error: '.$th->getMessage());
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
        $tags = Tags::find($id);
        if(!$tags){ 
            return redirect()->back()->with('error','Not Found');
        }
        $request->validate(['name'=>'required']);
        DB::beginTransaction();
        try {
            $tags->update([
                'tag_name'=>strtolower($request->name),
            ]);
            DB::commit();
            return redirect()->back()->with('success','Tags Updated');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error','Error: '.$th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tags = Tags::find($id);
        if(!$tags){ 
            return redirect()->back()->with('error','Not Found');
        }
        DB::beginTransaction();
        try {
            $tags->delete();
            DB::commit();
            return redirect()->back()->with('success','Tags Deleted');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error','Error: '.$th->getMessage());
        }
    }
}
