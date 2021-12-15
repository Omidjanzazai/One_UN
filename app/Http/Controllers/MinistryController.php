<?php

namespace App\Http\Controllers;

use App\Models\Ministry;
use Illuminate\Http\Request;

class MinistryController extends Controller
{
    public function __construct($sub_menu = null)
    {
        session()->flash('menu','Ministries');
        session()->flash('sub-menu', $sub_menu);
    }


    public function ministry(Request $request)
    {
        $this->__construct('Ministries');

        $data = Ministry::join('country', 'country.id', 'ministry.country_id')
        ->select('ministry.id', 'ministry.name', 'ministry.acronym', 'ministry.sector', 'ministry.country_id', 'country.name as country_name')
        ->paginate(10);

        if ($request->ajax()) {
            return view('ministry.pagination_data',compact('data'));
        }

        return view('ministry.index',compact('data'));
    }


    public function filter_ministry(Request $request)
    {
        if ($request->name == null and $request->country_id == null and $request->acronym != null and $request->sector != null) {
            return $this->ministry($request);
        }

        $data = Ministry::join('country', 'country.id', 'ministry.country_id')
        ->when($request->name != null , function($query) use ($request){
            return $query->where('ministry.name', 'like', '%'.$request->name.'%');
        })
        ->when($request->country_id != null , function($query) use ($request){
            return $query->where('ministry.country_id', $request->country_id);
        })
        ->when($request->acronym != null , function($query) use ($request){
            return $query->where('ministry.acronym', 'like', '%'.$request->acronym.'%');
        })
        ->when($request->sector != null , function($query) use ($request){
            return $query->where('ministry.sector', 'like', '%'.$request->sector.'%');
        })
        ->select('ministry.id', 'ministry.name', 'ministry.acronym', 'ministry.sector', 'ministry.country_id', 'country.name as country_name')
        ->get();

        return view('ministry.pagination_data', compact('data'));
    }


    public function store_ministry(Request $request)
    {
        $request->validate([
            'country_id' => 'required',
            'name' => 'required',
            'acronym' => 'required',
            'sector' => 'required',
        ]);

        Ministry::create($request->only('country_id', 'name', 'acronym','sector'));

        session()->flash('success', 'Created Successfuly.');
        
        return redirect()->back();
    }


    public function update_ministry(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'country_id' => 'required',
            'name' => 'required',
            'acronym' => 'required',
            'sector' => 'required',
        ]);

        Ministry::where('id', $request->id)->update($request->only('country_id', 'name', 'acronym','sector'));
        
        session()->flash('success', 'Updated Successfuly.');
        
        return redirect()->back();
    }


    public function delete_ministry(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        Ministry::where('id', $request->id)->delete();
        
        session()->flash('success', 'Deleted Successfuly.');
        
        return redirect()->back();
    }
}
