<?php

namespace App\Http\Controllers\Admin;

use App\Models\Filter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FilterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = Filter::orderBy('id', 'desc')
        ->get();
        return view('admin.modules.filters.index', compact('filters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.modules.filters.form');
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
            $filter = Filter::where('id', $update_id)->first();
            $filter->update($request->all());
            notify()->success('Filter updated successfully!');
            return redirect()->route('admin:filters');
        } else {
            $filter = Filter::create(['title' => $request->title]);
            $last_id = $filter->id;
            if (isset($last_id) && !empty($last_id)) {
                notify()->success('Filter added successfully!');
                return redirect()->route('admin:filters');
            } else {
                notify()->error('Something Went wrong!');
                return back();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Filter  $filter
     * @return \Illuminate\Http\Response
     */
    public function show(Filter $filter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Filter  $filter
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $filter = Filter::find($id);
        return view('admin.modules.filters.form', compact('filter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Filter  $filter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Filter $filter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Filter  $filter
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $filter = Filter::find($id);
        $filter->delete();
        notify()->success('Filter deleted successfully!');
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
            $change = Filter::where('id', $id)->update(['status' => $status]);
            $status = true;
            $message = "Status Changed";
            notify()->success('Status Changed!');
        }
        return response()->json(['status' => $status, 'message' => $message]);
    }
}
