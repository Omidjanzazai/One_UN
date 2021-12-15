<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Village;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function __construct($sub_menu = null)
    {
        session()->flash('menu','Configuration');
        session()->flash('sub-menu', $sub_menu);
    }

// Country Functions
    public function country_provinces(Request $request)
    {
        $provinces = Province::where('country_id', $request->country_id)->get();
        $data = '<option value="">--Select Province--</option>';
        foreach ($provinces as $item) {
            $data .= '<option value="'.$item->id.'">'.$item->name.'</option>';
        }

        return $data;
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
        if ($request->value == null) {
            return $this->country($request);
        }

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

// Province Functions
    public function province_districts(Request $request)
    {
        $districts = District::where('province_id', $request->province_id)->get();
        $data = '<option value="">--Select Province--</option>';
        foreach ($districts as $item) {
            $data .= '<option value="'.$item->id.'">'.$item->name.'</option>';
        }

        return $data;
    }


    public function province(Request $request)
    {
        $this->__construct('Province');

        $data = Province::join('country', 'country.id', 'province.country_id')
        ->select('province.id', 'province.name', 'country.name as country_name', 'country.id as country_id')
        ->paginate(10);

        if ($request->ajax()) {
            return view('configuration.province.pagination_data', compact('data'));
        }

        return view('configuration.province.index', compact('data'));
    }


    public function filter_province(Request $request)
    {
        if ($request->name == null and $request->country_id == null) {
            return $this->province($request);
        }

        $data = Province::join('country', 'country.id', 'province.country_id')
        ->when($request->name != null , function($query) use ($request){
            return $query->where('province.name', 'like', '%'.$request->name.'%');
        })
        ->when($request->country_id != null , function($query) use ($request){
            return $query->where('province.country_id', $request->country_id);
        })
        ->select('province.id', 'province.name', 'country.name as country_name', 'country.id as country_id')
        ->get();

        return view('configuration.province.pagination_data', compact('data'));
    }


    public function store_province(Request $request)
    {
        $request->validate([
            'country_id' => 'required',
            'name' => 'required',
        ]);

        Province::create($request->only('country_id', 'name'));

        session()->flash('success', 'Created Successfuly.');
        
        return redirect()->back();
    }


    public function update_province(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'country_id' => 'required',
            'name' => 'required',
        ]);

        Province::where('id', $request->id)->update($request->only('country_id', 'name'));

        session()->flash('success', 'Updated Successfuly.');
        
        return redirect()->back();
    }


    public function delete_province(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        Province::where('id', $request->id)->delete();
        
        session()->flash('success', 'Deleted Successfuly.');

        return redirect()->back();
    }

// Disctrict Functions
    public function district(Request $request)
    {
        $this->__construct('District');

        $data = District::join('province', 'province.id', 'district.province_id')
        ->join('country', 'country.id', 'province.country_id')
        ->select('district.id', 'district.name', 'district.province_id', 'province.name as province_name', 'province.country_id', 'country.name as country_name')
        ->paginate(10);

        if ($request->ajax()) {
            return view('configuration.district.pagination_data',compact('data'));
        }

        return view('configuration.district.index',compact('data'));
    }


    public function filter_district(Request $request)
    {
        if ($request->name == null and $request->country_id == null and $request->province_id != null) {
            return $this->district($request);
        }

        $data = District::join('province', 'province.id', 'district.province_id')
        ->join('country', 'country.id', 'province.country_id')
        ->when($request->name != null , function($query) use ($request){
            return $query->where('district.name', 'like', '%'.$request->name.'%');
        })
        ->when($request->country_id != null , function($query) use ($request){
            return $query->where('province.country_id', $request->country_id);
        })
        ->when($request->province_id != null , function($query) use ($request){
            return $query->where('district.province_id', $request->province_id);
        })
        ->select('district.id', 'district.name', 'district.province_id', 'province.name as province_name', 'province.country_id', 'country.name as country_name')
        ->get();

        return view('configuration.district.pagination_data', compact('data'));
    }


    public function store_district(Request $request)
    {
        $request->validate([
            'province_id' => 'required',
            'name' => 'required',
        ]);

        District::create($request->only('province_id', 'name'));

        session()->flash('success', 'Created Successfuly.');
        
        return redirect()->back();
    }


    public function update_district(Request $request)
    {
        $request->validate([
            'province_id' => 'required',
            'name' => 'required',
        ]);
        
        District::where('id', $request->id)->update($request->only('province_id', 'name'));
        
        session()->flash('success', 'Updated Successfuly.');

        return redirect()->back();
    }


    public function delete_district(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        District::where('id', $request->id)->delete();
        
        session()->flash('success', 'Deleted Successfuly.');
        
        return redirect()->back();
    }

// Village Functions
    public function village(Request $request)
    {
        $this->__construct('Village');

        $data = Village::join('district', 'district.id', 'village.district_id')
        ->join('province', 'province.id', 'district.province_id')
        ->join('country', 'country.id', 'province.country_id')
        ->select('village.id', 'village.name', 'village.district_id', 'district.name as district_name', 'district.province_id', 'province.name as province_name', 'province.country_id', 'country.name as country_name')
        ->paginate(10);

        if ($request->ajax()) {
            return view('configuration.village.pagination_data',compact('data'));
        }

        return view('configuration.village.index',compact('data'));
    }


    public function filter_village(Request $request)
    {
        if ($request->name == null and $request->country_id == null and $request->province_id != null and $request->district_id) {
            return $this->village($request);
        }

        $data = Village::join('district', 'district.id', 'village.district_id')
        ->join('province', 'province.id', 'district.province_id')
        ->join('country', 'country.id', 'province.country_id')
        ->when($request->name != null , function($query) use ($request){
            return $query->where('village.name', 'like', '%'.$request->name.'%');
        })
        ->when($request->country_id != null , function($query) use ($request){
            return $query->where('province.country_id', $request->country_id);
        })
        ->when($request->province_id != null , function($query) use ($request){
            return $query->where('district.province_id', $request->province_id);
        })
        ->when($request->district_id != null , function($query) use ($request){
            return $query->where('village.district_id', $request->district_id);
        })
        ->select('village.id', 'village.name', 'village.district_id', 'district.name as district_name', 'district.province_id', 'province.name as province_name', 'province.country_id', 'country.name as country_name')
        ->get();

        return view('configuration.village.pagination_data', compact('data'));
    }


    public function store_village(Request $request)
    {
        $request->validate([
            'district_id' => 'required',
            'name' => 'required',
        ]);

        Village::create($request->only('district_id', 'name'));

        session()->flash('success', 'Created Successfuly.');
        
        return redirect()->back();
    }


    public function update_village(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'district_id' => 'required',
            'name' => 'required',
        ]);

        Village::where('id', $request->id)->update($request->only('district_id', 'name'));
        
        session()->flash('success', 'Updated Successfuly.');

        return redirect()->back();
    }


    public function delete_village(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        Village::where('id', $request->id)->delete();
        
        session()->flash('success', 'Deleted Successfuly.');
        
        return redirect()->back();
    }


    // public function country(Request $request)
    // {
    //     $this->__construct('users');

    //     $data = Country::paginate(10);

    //     if ($request->ajax()) {
    //         return view('configuration.country.pagination_data',compact('data'));
    //     }

    //     return view('configuration.country.index',compact('data'));
    // }


    // public function filter_country(Request $request)
    // {
    //     $data = Province::join('country', 'country.id', 'province.country_id')
    //     ->when($request->name != null , function($query) use ($request){
    //         return $query->where('province.name', 'like', '%'.$request->name.'%');
    //     })
    //     ->when($request->country_id != null , function($query) use ($request){
    //         return $query->where('province.country_id', $request->country_id);
    //     })
    //     ->select('province.id', 'province.name', 'country.name as country_name', 'country.id as country_id')
    //     ->get();

    //     return view('configuration.country.pagination_data', compact('data'));
    // }


    // public function store_country(Request $request)
    // {
    //     $request->validate([

    //     ]);

    //     session()->flash('success', 'Created Successfuly.');
        
    //     return redirect()->back();
    // }


    // public function update_country(Request $request)
    // {
    //     $request->validate([

    //     ]);
        
    //     session()->flash('success', 'Updated Successfuly.');
    //     return redirect()->back();
    // }


    // public function delete_country(Request $request)
    // {
    //     $request->validate([
    //         'id' => 'required',
    //     ]);
        
    //     session()->flash('success', 'Deleted Successfuly.');
        
    //     return redirect()->back();
    // }
}
