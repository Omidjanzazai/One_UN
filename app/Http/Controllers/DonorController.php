<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function __construct($sub_menu = null)
    {
        session()->flash('menu','Donors');
        session()->flash('sub-menu', $sub_menu);
    }


    public function donor(Request $request)
    {
        $this->__construct('Donors');

        $data = Donor::join('country', 'country.id', 'donor.country_id')
        ->select('donor.id', 'donor.name', 'donor.country_id', 'country.name as country_name')
        ->paginate(10);

        if ($request->ajax()) {
            return view('donor.pagination_data',compact('data'));
        }

        return view('donor.index',compact('data'));
    }


    public function filter_donor(Request $request)
    {
        if ($request->name == null and $request->country_id == null) {
            return $this->donor($request);
        }

        $data = Donor::join('country', 'country.id', 'donor.country_id')
        ->when($request->name != null , function($query) use ($request){
            return $query->where('donor.name', 'like', '%'.$request->name.'%');
        })
        ->when($request->country_id != null , function($query) use ($request){
            return $query->where('donor.country_id', $request->country_id);
        })
        ->select('donor.id', 'donor.name', 'donor.country_id', 'country.name as country_name')
        ->get();

        return view('donor.pagination_data', compact('data'));
    }


    public function store_donor(Request $request)
    {
        $request->validate([
            'country_id' => 'required',
            'name' => 'required',
        ]);

        Donor::create($request->only('country_id', 'name'));

        session()->flash('success', 'Created Successfuly.');
        
        return redirect()->back();
    }


    public function update_donor(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'country_id' => 'required',
            'name' => 'required',
        ]);

        Donor::where('id', $request->id)->update($request->only('country_id', 'name'));
        
        session()->flash('success', 'Updated Successfuly.');
        
        return redirect()->back();
    }


    public function delete_donor(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        Donor::where('id', $request->id)->delete();
        
        session()->flash('success', 'Deleted Successfuly.');
        
        return redirect()->back();
    }
}
