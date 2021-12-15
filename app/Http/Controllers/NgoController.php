<?php

namespace App\Http\Controllers;

use App\Models\Ngo;
use Illuminate\Http\Request;

class NgoController extends Controller
{
    public function __construct($sub_menu = null)
    {
        session()->flash('menu','NGOs');
        session()->flash('sub-menu', $sub_menu);
    }

    public function ngo($type, Request $request)
    {
        if ($type == 'Inernational NGOs') {
            $this->__construct('Inernational NGOs');
        }
        if ($type == 'National NGOs') {
            $this->__construct('National NGOs');
        }

        $data = Ngo::when($type == 'Inernational NGOs' , function($query) use ($type){
            return $query->where('ngo.type', 1);
        })
        ->when($type == 'National NGOs' , function($query) use ($type){
            return $query->where('ngo.type', 2);
        })->paginate(10);

        if ($request->ajax()) {
            return view('ngo.pagination_data',compact('data'));
        }

        return view('ngo.index', compact('data'));
    }


    public function filter_ngo($type, Request $request)
    {
        if ($request->value == null) {
            return $this->ngo($type, $request);
        }
        
        if ($type == 'Inernational NGOs') {
            $this->__construct('Inernational NGOs');
        }
        if ($type == 'National NGOs') {
            $this->__construct('National NGOs');
        }

        $data = Ngo::when($request->search_by == 'Name' , function($query) use ($request){
            return $query->where('ngo.name', 'like', '%'.$request->value.'%');
        })
        ->when($request->search_by == 'Acronym' , function($query) use ($request){
            return $query->where('ngo.acronym', 'like', '%'.$request->value.'%');
        })
        ->when($type == 'Inernational NGOs' , function($query) use ($request){
            return $query->where('ngo.type', 1);
        })
        ->when($type == 'National NGOs' , function($query) use ($request){
            return $query->where('ngo.type', 2);
        })->get();

        return view('ngo.pagination_data', compact('data'));
    }


    public function store_ngo($type, Request $request)
    {
        $request->validate([
            'type' => 'required',
            'name' => 'required',
            'acronym' => 'required',
        ]);

        Ngo::create($request->only('type', 'name', 'acronym'));
        
        session()->flash('success', 'Created Successfuly.');

        return redirect()->back();
    }


    public function update_ngo($type, Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'acronym' => 'required',
        ]);

        Ngo::where('id', $request->id)->update($request->only('name', 'acronym'));

        session()->flash('success', 'Updated Successfuly.');
        
        return redirect()->back();
    }


    public function delete_ngo($type, Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        Ngo::where('id', $request->id)->delete();
        
        session()->flash('success', 'Deleted Successfuly.');
        
        return redirect()->back();
    }
}
