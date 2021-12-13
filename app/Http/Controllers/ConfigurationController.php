<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function __construct($sub_menu = null)
    {
        session()->flash('menu','Configuration');
        session()->flash('sub-menu', $sub_menu);
    }


    public function country(Request $request)
    {
        $this->__construct('Country');

        $data = Country::paginate(10);

        if ($request->ajax()) {
            return view('configuration.country.pagination_data',compact('data'));
        }

        return view('configuration.country.index', compact('data'));
    }


    public function filter_country(Request $request)
    {
        $data = Country::when($request->search_by == 'Name' , function($query) use ($request){
            return $query->where('country.name', 'like', '%'.$request->value.'%');
        })
        ->when($request->search_by == 'Acronym' , function($query) use ($request){
            return $query->where('country.acronym', 'like', '%'.$request->value.'%');
        })->get();

        return view('configuration.country.pagination_data', compact('data'));
    }


    public function store_country(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'acronym' => 'required',
        ]);

        Country::create($request->all());
        
        session()->flash('success', 'Created Successfuly.');

        return redirect()->back();
    }


    public function update_country(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'acronym' => 'required',
        ]);

        Country::where('id', $request->id)->update($request->only('name', 'acronym'));

        session()->flash('success', 'Updated Successfuly.');
        
        return redirect()->back();
    }


    public function delete_country(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        Country::where('id', $request->id)->delete();
        
        session()->flash('success', 'Deleted Successfuly.');
        
        return redirect()->back();
    }


    // public function country(Request $request)
    // {
    //     $this->__construct('users');

    //     if ($request->ajax()) {
    //         return view('configuration.country.pagination_data',compact('country'));
    //     }

    //     return view('configuration.country.index');
    // }


    // public function store_country(Request $request)
    // {
    //     $request->validate([

    //     ]);
        
    //     return redirect()->back();
    // }


    // public function update_country(Request $request)
    // {
    //     $request->validate([

    //     ]);
        
    //     return redirect()->back();
    // }


    // public function delete_country(Request $request)
    // {
    //     $request->validate([

    //     ]);
        
    //     return redirect()->back();
    // }
}
