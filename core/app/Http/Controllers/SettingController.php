<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'APP Settings';
        $data['apps'] = Settings::where('group','APP')->get();
        $data['banks'] = Settings::where('group','BANK')->get();
        $data['wa'] = Settings::where('group','WA')->get();
        $data['mail'] = Settings::where('group','MAIL')->get();
        return view('dashboard.settings.app',$data);
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
        $settings = Settings::all();
        DB::beginTransaction();
        try {
            foreach ($settings as $key => $value) {
                Settings::find($value->key)->update(['value' =>$request[$value->key] ]);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Settings updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
