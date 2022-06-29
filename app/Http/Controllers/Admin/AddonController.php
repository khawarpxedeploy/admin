<?php

namespace App\Http\Controllers\Admin;

use App\Models\Addon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddonController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addons = Addon::orderBy('id', 'desc')
        ->get();
        return view('admin.modules.addons.index', compact('addons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.modules.addons.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $update_id = $request->id;

        if (isset($update_id) && !empty($update_id) && $update_id != 0) {
            $addon = Addon::where('id', $update_id)->first();
            $addon->update($request->all());
            notify()->success('Addon updated successfully!');
            return redirect()->route('admin:addons');
        } else {
            $addon = Addon::create($request->all());
            $last_id = $addon->id;
            if (isset($last_id) && !empty($last_id)) {
                notify()->success('Addon added successfully!');
                return redirect()->route('admin:addons');
            } else {
                notify()->error('Something Went wrong!');
                return back();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Addon  $addon
     * @return \Illuminate\Http\Response
     */
    public function show(Addon $addon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Addon  $addon
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $addon = Addon::find($id);
        return view('admin.modules.addons.form', compact('addon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Addon  $addon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Addon $addon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Addon  $addon
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $addon = Addon::find($id);
        $addon->delete();
        notify()->success('Addon deleted successfully!');
        return back();
    }

    public function change_status(Request $request)
    {
        $status = false;
        $message = "Error in Changing Status";
        $id = $request->id;
        $status = $request->status;
        if (isset($id) && !empty($id)) {
            if ($status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $change = Addon::where('id', $id)->update(['status' => $status]);
            $status = true;
            $message = "Status Changed";
            notify()->success('Status Changed!');
        }
        return response()->json(['status' => $status, 'message' => $message]);
    }
}
