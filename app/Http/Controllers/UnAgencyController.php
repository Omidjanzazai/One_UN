<?php

namespace App\Http\Controllers;

use App\Models\UnAgency;
use Illuminate\Http\Request;

class UnAgencyController extends Controller
{
    public function __construct($sub_menu = null)
    {
        session()->flash('menu','UN Agencies');
        session()->flash('sub-menu', $sub_menu);
    }


    public function un_agencies_donors(Request $request)
    {
        $donors = UnAgency::join('un_agency_donor', 'un_agency_donor.un_agency_id', 'un_agencies.id')
        ->join('donor', 'donor.id', 'un_agency_donor.donor_id')
        ->join('country', 'country.id', 'donor.country_id')
        ->where('un_agencies.id', $request->id)
        ->select('donor.name', 'country.name as country_name')
        ->get();
        $data = '';

        $x = 1;
        foreach ($donors as $item) {
            $data .= '
            <tr>
                <td>'.$x++.'</td>
                <td>'.$item->name.'</td>
                <td>'.$item->country_name.'</td>
            </tr>';
        }

        return $data;
    }


    public function un_agencies(Request $request)
    {
        $this->__construct('UN Agencies');

        $data = UnAgency::paginate(10);

        if ($request->ajax()) {
            return view('un_agencies.pagination_data',compact('data'));
        }

        return view('un_agencies.index', compact('data'));
    }


    public function filter_un_agencies(Request $request)
    {
        if ($request->value == null) {
            return $this->un_agencies($request);
        }

        $data = UnAgency::when($request->search_by == 'Name' , function($query) use ($request){
            return $query->where('un_agencies.name', 'like', '%'.$request->value.'%');
        })
        ->when($request->search_by == 'Acronym' , function($query) use ($request){
            return $query->where('un_agencies.acronym', 'like', '%'.$request->value.'%');
        })->get();

        return view('un_agencies.pagination_data', compact('data'));
    }


    public function store_un_agencies(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'acronym' => 'required',
        ]);

        UnAgency::create($request->only('name', 'acronym'));
        
        session()->flash('success', 'Created Successfuly.');

        return redirect()->back();
    }


    public function update_un_agencies(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'acronym' => 'required',
        ]);

        UnAgency::where('id', $request->id)->update($request->only('name', 'acronym'));

        session()->flash('success', 'Updated Successfuly.');
        
        return redirect()->back();
    }


    public function delete_un_agencies(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        UnAgency::where('id', $request->id)->delete();
        
        session()->flash('success', 'Deleted Successfuly.');
        
        return redirect()->back();
    }
}
