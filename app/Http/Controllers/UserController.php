<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use App\Models\Role;
use App\Models\User;
use App\Models\AccessDomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        
        $auth_user = Auth::user();
        
        $jobs = \App\Models\Jobs::where('type', $auth_user->type)->where('subject_id', $auth_user->subject_id)->get();

        return view('auth.create_user',compact('jobs'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'phone_number'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed|min:6',
            'user_type'=>'required',
        ]);

        DB::beginTransaction();

        try {
            $user = new User();
            
            $directory = 'assets/images/user_images';
            if($photo = $request->file('photo')){
                $name = $photo->getClientOriginalName();
                $filename = pathinfo($name, PATHINFO_FILENAME);
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $new_name = $filename.'-'.time().'.'.$extension;
                $photo->move($directory,$new_name);
                $user->photo= $directory.'/'.$new_name;
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->job_id = $request->user_type;
            $user->type = $request->user()->type;
            $user->subject_id = $request->user()->subject_id;
            $user->phone_number = $request->phone_number;
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
                    
            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            session()->flash('warning', 'Something where wrong please contact Database Adminstrator.');
            return redirect()->back();
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

        $auth_user = Auth::user();

        $users = User::leftjoin('job', 'job.id', 'users.job_id')
        ->where('users.type', $auth_user->type)
        ->where('users.subject_id', $auth_user->subject_id)
        ->select('users.*', 'job.name as user_type', 'job.id as job_id')->get();
        
        $jobs = Jobs::where('type', $auth_user->type)->where('subject_id', $auth_user->subject_id)->get();

        return view('auth.show',compact('users','jobs'));
    }

    public function user_info($id)
    {
        $this->__construct('All Users');

        $auth_user = Auth::user();

        $user = User::leftjoin('job', 'job.id', 'users.job_id')
        ->where('users.type', $auth_user->type)
        ->where('users.subject_id', $auth_user->subject_id)
        ->where('users.id', $id)
        ->select('users.*', 'job.name as position', 'job.id as job_id')->first();
        
        $jobs = Jobs::where('type', $auth_user->type)->where('subject_id', $auth_user->subject_id)->get();

        return view('auth.user_info',compact('user','jobs'));
    }

    public function user_info_update($id, Request $request)
    {
        DB::beginTransaction();

        try {
            $auth_user = Auth::user();

            $user = User::where('users.type', $auth_user->type)
            ->where('users.subject_id', $auth_user->subject_id)
            ->where('users.id', $id)->first();
            
            $user->name = $request->name;
            $user->phone_number = $request->phone_number;
            $user->email = $request->email;
            $user->information = $request->information;
            
            if($photo = $request->file('photo')){
                $directory = 'assets/images/user_images';
                $name = $photo->getClientOriginalName();
                $filename = pathinfo($name, PATHINFO_FILENAME);
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $new_name = $filename.'-'.time().'.'.$extension;
                $photo->move($directory,$new_name);
                $user->photo= $directory.'/'.$new_name;
            }
            
            if ($user->job_id != $request->user_type) {
                $user->job_id = $request->user_type;
                
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
            }
            $user->update();
            
            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            session()->flash('warning', 'Something where wrong please contact Database Adminstrator.');
            return redirect()->back();
        }

        return redirect()->back();
    }

    public function reset_password(Request $request)
    {
        $this->__construct('All Users');
        
        DB::beginTransaction();

            try {
            $auth_user = Auth::user();

            $user = User::where('type', $auth_user->type)
            ->where('subject_id', $auth_user->subject_id)
            ->where('id',$request->id)
            ->first();
            $user->password = Hash::make($request->password);

            $user->update();
                        
            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            session()->flash('warning', 'Something where wrong please contact Database Adminstrator.');
            return redirect()->back();
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

    public function destroy($email, Request $request)
    {
        $this->__construct('All Users');
        DB::beginTransaction();

        try {
            $auth_user = Auth::user();
            
            $user = User::where('type', $auth_user->type)
            ->where('subject_id', $auth_user->subject_id)
            ->where('id', $request->id)
            ->first();
            $user->delete();

            $user->roles()->detach();
            $user->accessDomains()->detach();

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            session()->flash('warning', 'Something where wrong please contact Database Adminstrator.');
            return redirect()->back();
        }

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

        $user = \App\Models\User::join('job', 'job.id', 'users.job_id')
        ->where('users.id', Auth::user()->id)
        ->select('users.*', 'job.name as position')->first();

        return view('auth.profile', compact('user'));
    }
    
    public function update_profile(Request $request)
    {
        $user = Auth::user();

        DB::beginTransaction();

        try {
            $directory = 'assets/images/user_images';
            if($photo = $request->file('photo')){
                $name = $photo->getClientOriginalName();
                $filename = pathinfo($name, PATHINFO_FILENAME);
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $new_name = $filename.'-'.time().'.'.$extension;
                $photo->move($directory,$new_name);
                $user->photo= $directory.'/'.$new_name;
            }

            $user->information = $request->information;
            $user->update();
                        
            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            session()->flash('warning', 'Something where wrong please contact Database Adminstrator.');
            return redirect()->back();
        }
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
            DB::beginTransaction();

            try {
                $request->user()->fill([
                    'password' => Hash::make($request->password)
                ])->save();
                            
                DB::commit();
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong

                session()->flash('warning', 'Something where wrong please contact Database Adminstrator.');
                return redirect()->back();
            }

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
        $auth_user = Auth::user();

        $access_domains = AccessDomain::where('type', $auth_user->type)->get();
        $domains = AccessDomain::where('type', $auth_user->type)->groupBy('domain')->select('domain')->get();
        $roles = Role::get();
        
        $jobs = Jobs::where('type', $auth_user->type)->where('subject_id', $auth_user->subject_id)->get();

        return view('auth.jobs.index',compact('access_domains','domains','roles', 'jobs'));
    }

    public function store_jobs(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'access_domain'=>'required',
            'role'=>'required',
        ]);

        DB::beginTransaction();

        try {
            $auth_user = Auth::user();

            $job = new Jobs();
            $job->name = $request->name;
            $job->type = $auth_user->type;
            $job->subject_id = $auth_user->subject_id;
            $job->save();

            for($i=0; $i<count($request->access_domain); $i++)
            {
                $job->accessDomains()->attach(AccessDomain::where('id',$request->access_domain[$i])->first());
            }
            for($i=0; $i<count($request->role); $i++)
            {
                $job->roles()->attach(Role::where('id',$request->role[$i])->first());
            }

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            session()->flash('warning', 'Something where wrong please contact Database Adminstrator.');
            return redirect()->back();
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
        DB::beginTransaction();

        try {
            $auth_user = Auth::user();

            $job = Jobs::where('type', $auth_user->type)->where('subject_id', $auth_user->subject_id)->where('id', $request->id)->first();
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
            
            $users = User::where('type', $auth_user->type)->where('subject_id', $auth_user->subject_id)->where('job_id', $request->id)->get();

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

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            session()->flash('warning', 'Something where wrong please contact Database Adminstrator.');
            return redirect()->back();
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

        DB::beginTransaction();

        try {
            $auth_user = Auth::user();

            $job = Jobs::where('type', $auth_user->type)->where('subject_id', $auth_user->subject_id)->where('id',$request->id)->first();

            $job->delete();

            $job->roles()->detach();
            $job->accessDomains()->detach();

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            session()->flash('warning', 'Something where wrong please contact Database Adminstrator.');
            return redirect()->back();
        }
        
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
