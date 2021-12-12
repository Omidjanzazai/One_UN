<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role','role_users','user_id','role_id');
    }


    public function hasAnyRole($roles)
    {
        if(is_array($roles)){
            foreach ($roles as $role){
                if($this->hasRole($role)){
                    return true;
                }
            }
        }
        else{
            if($this->hasRole($roles)){
                return true;
            }
        }

        return false;
    }


    public function hasRole($role)
    {
        if($this->roles()->where('role',$role)->first()){
            return true;
        }

        return false;
    }


    public function accessDomains()
    {
        return $this->belongsToMany('App\Models\AccessDomain','access_domain_users','user_id','access_domain_id');
    }


    public function hasAnyAccessDomain($access_domains)
    {
        if(is_array($access_domains)){
            foreach($access_domains as $access_domain){
                if($this->hasAccessDomain($access_domain)){
                    return true;
                }
            }
        }else{
            if($this->hasAccessDomain($access_domains)){
                return true;
            }
        }

        return false;
    }


    public function hasAccessDomain($access_domain)
    {
        if($this->accessDomains()->where('item',$access_domain)->first()){
            return true;
        }
    }
}
