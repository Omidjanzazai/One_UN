<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use App\Models\Role;
use App\Models\User;
use App\Models\AccessDomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct($sub_menu = null)
    {
        session()->flash('menu','User Management');
        session()->flash('sub-menu', $sub_menu);
    }

    public function create()
    {
        $this->__construct('register');
        $access_domains = AccessDomain::get();
        $domains = AccessDomain::groupBy('domain')->select('domain')->get();
        $roles = Role::get();

        return view('auth.create_user',compact('access_domains','domains','roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed|min:6',
        ]);

        $user = new User();
        // $user->type = 1;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->job_id = $request->user_type;

        $user->save();

        $job = Jobs::where('id', $request->user_type)->first();

        for($i=0; $i<count($job->accessDomains); $i++)
        {
            $user->accessDomains()->attach(AccessDomain::where('id',$job->accessDomains[$i]->id)->first());
        }
        for($i=0; $i<count($job->roles); $i++)
        {
            $user->roles()->attach(Role::where('id',$job->roles[$i]->id)->first());
        }

        $locale = App::getLocale();
        switch ($locale) {
            case 'en':
                session()->flash('success', 'Created Successfuly.');
                break;

            case 'fa':
                session()->flash('success', 'موفقانه ایجاد گردید.');
                break;

            case 'pa':
                session()->flash('success', 'په بریالی توگه اضافه شو.');
                break;

            default:
                break;
        }
        return redirect()->back();
    }

    public function show()
    {
        $this->__construct('All Users');
        $users = User::leftjoin('job', 'job.id', 'users.job_id')
        ->select('users.*', 'job.name as user_type', 'job.id as job_id')->get();
        $access_domains = AccessDomain::get();
        $domains = AccessDomain::groupBy('domain')->select('domain')->get();
        $roles = Role::get();
        return view('auth.show',compact('users','access_domains','domains','roles'));
    }

    public function change_permission(Request $request)
    {
        $this->__construct('All Users');
        $user = User::where('email',$request->email)->first();
        $user->job_id = $request->user_type;
        $user->update();
        
        $user->roles()->detach();
        $user->accessDomains()->detach();

        $job = Jobs::where('id', $request->user_type)->first();

        for($i=0; $i<count($job->accessDomains); $i++)
        {
            $user->accessDomains()->attach(AccessDomain::where('id',$job->accessDomains[$i]->id)->first());
        }
        for($i=0; $i<count($job->roles); $i++)
        {
            $user->roles()->attach(Role::where('id',$job->roles[$i]->id)->first());
        }

        $locale = App::getLocale();
        switch ($locale) {
            case 'en':
                session()->flash('success', 'Updated Successfuly.');
                break;

            case 'fa':
                session()->flash('success', 'موفقانه اپدیت گردید.');
                break;

            case 'pa':
                session()->flash('success', 'په بریالی توگه اپدیت شو.');
                break;

            default:
                break;
        }
        return redirect()->route('user-show');
    }

    public function reset_password(Request $request)
    {
        $this->__construct('All Users');
        $user = User::where('email',$request->email)->first();

        $user->password = Hash::make($request->password);

        $user->save();

        $locale = App::getLocale();
        switch ($locale) {
            case 'en':
                session()->flash('success', 'Updated Successfuly.');
                break;

            case 'fa':
                session()->flash('success', 'موفقانه اپدیت گردید.');
                break;

            case 'pa':
                session()->flash('success', 'په بریالی توگه اپدیت شو.');
                break;

            default:
                break;
        }
        return redirect()->route('user-show');
    }

    public function destroy($email)
    {
        $this->__construct('All Users');
        $user = User::where('email',$email)->first();

        $user->delete();

        $user->roles()->detach();
        $user->accessDomains()->detach();

        $locale = App::getLocale();
        switch ($locale) {
            case 'en':
                session()->flash('success', 'Deleted Successfuly.');
                break;

            case 'fa':
                session()->flash('success', 'موفقانه حذف گردید.');
                break;

            case 'pa':
                session()->flash('success', 'په بریالی توگه پاک شو.');
                break;

            default:
                break;
        }
        return redirect()->route('user-show');
    }
    
    public function profile()
    {
        $this->__construct('');
        session()->flash('menu', 'Profile');

        return view('auth.profile');
    }
    
    public function update_profile(Request $request)
    {
        $user = Auth::user();

        $directory = 'assets/images/user_images';
        if($photo = $request->file('photo')){
            $name = $photo->getClientOriginalName();
            $filename = pathinfo($name, PATHINFO_FILENAME);
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $new_name = $filename.'-'.time().'.'.$extension;
            $photo->move($directory,$new_name);
            $user->photo= $directory.'/'.$new_name;
        }

        $user->position = $request->position;
        $user->phone_number = $request->phone_number;
        $user->information = $request->information;
        $user->update();

        session()->flash('success', 'Updated Successfuly');

        return redirect()->back();
    }

    public function change_password(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if (Hash::check($request->old_password, Auth::user()->password)){
            $request->user()->fill([
                'password' => Hash::make($request->password)
            ])->save();

            $locale = App::getLocale();
            switch ($locale) {
                case 'en':
                    session()->flash('success', 'Password Successfuly Changed.');
                    break;
                
                case 'fa':
                    session()->flash('success', 'پسورد موفقانه تبدیل گردید.');
                    break;
                
                case 'pa':
                    session()->flash('success', 'کود په بریالی توگه بدل شو.');
                    break;
                
                default:
                    break;
            }

            return redirect()->back();
        }
        else{
            $locale = App::getLocale();
            switch ($locale) {
                case 'en':
                    session()->flash('warning', "old password doesn't match!");
                    break;
                
                case 'fa':
                    session()->flash('warning', 'پسورد سابقه اشتباه است.');
                    break;
                
                case 'pa':
                    session()->flash('warning', 'پخوانی کود غلط ده.');
                    break;
                
                default:
                    break;
            }
            return redirect()->back();
        }

    }

    public function jobs()
    {
        $this->__construct('User Jobs');
        $access_domains = AccessDomain::get();
        $domains = AccessDomain::groupBy('domain')->select('domain')->get();
        $roles = Role::get();
        
        $jobs = Jobs::where('type', 1)->get();

        return view('auth.jobs.index',compact('access_domains','domains','roles', 'jobs'));
    }

    public function store_jobs(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'access_domain'=>'required',
            'role'=>'required',
        ]);

        $job = new Jobs();
        $job->name = $request->name;
        $job->type = 1;
        $job->save();

        for($i=0; $i<count($request->access_domain); $i++)
        {
            $job->accessDomains()->attach(AccessDomain::where('id',$request->access_domain[$i])->first());
        }
        for($i=0; $i<count($request->role); $i++)
        {
            $job->roles()->attach(Role::where('id',$request->role[$i])->first());
        }

        $locale = App::getLocale();
        switch ($locale) {
            case 'en':
                session()->flash('success', 'Created Successfuly.');
                break;

            case 'fa':
                session()->flash('success', 'موفقانه ایجاد گردید.');
                break;

            case 'pa':
                session()->flash('success', 'په بریالی توگه اضافه شو.');
                break;

            default:
                break;
        }
        return redirect()->back();
    }
    
    public function update_jobs(Request $request)
    {
        $job = Jobs::where('id', $request->id)->first();
        $job->name = $request->name;
        $job->update();

        $job->roles()->detach();
        $job->accessDomains()->detach();

        for($i=0; $i<count($request->access_domain); $i++)
        {
            $job->accessDomains()->attach(AccessDomain::where('id',$request->access_domain[$i])->first());
        }

        for($i=0; $i<count($request->role); $i++)
        {
            $job->roles()->attach(Role::where('id',$request->role[$i])->first());
        }
        
        $users = User::where('job_id', $request->id)->get();

        foreach ($users as $item)
        {
            $user = User::where('id', $item->id)->first();
            $user->roles()->detach();
            $user->accessDomains()->detach();
    
            $job = Jobs::where('id', $request->id)->first();
    
            for($i=0; $i<count($job->accessDomains); $i++)
            {
                $user->accessDomains()->attach(AccessDomain::where('id',$job->accessDomains[$i]->id)->first());
            }
            for($i=0; $i<count($job->roles); $i++)
            {
                $user->roles()->attach(Role::where('id',$job->roles[$i]->id)->first());
            }
        }

        $locale = App::getLocale();
        switch ($locale) {
            case 'en':
                session()->flash('success', 'Updated Successfuly.');
                break;

            case 'fa':
                session()->flash('success', 'موفقانه اپدیت گردید.');
                break;

            case 'pa':
                session()->flash('success', 'په بریالی توگه اپدیت شو.');
                break;

            default:
                break;
        }
        return redirect()->back();
    }

    public function delete_jobs(Request $request)
    {
        $this->validate($request,[
            'id'=>'required',
        ]);

        $job = Jobs::where('id',$request->id)->first();

        $job->delete();

        $job->roles()->detach();
        $job->accessDomains()->detach();

        $locale = App::getLocale();
        switch ($locale) {
            case 'en':
                session()->flash('success', 'Deleted Successfuly.');
                break;

            case 'fa':
                session()->flash('success', 'موفقانه حذف گردید.');
                break;

            case 'pa':
                session()->flash('success', 'په بریالی توگه پاک شو.');
                break;

            default:
                break;
        }
        return redirect()->back();
    }
}
