<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    use HasFactory;

    protected $table = 'job';
    
    protected $guarded = ['deleted_at', 'created_at', 'updated_at'];
    
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role','job_roles','job_id','role_id');
    }

    public function accessDomains()
    {
        return $this->belongsToMany('App\Models\AccessDomain','job_access_domains','job_id','access_domain_id');
    }
    
    public function hasRole($role)
    {
        if($this->roles()->where('role',$role)->first()){
            return true;
        }

        return false;
    }

    public function hasAccessDomain($access_domain)
    {
        if($this->accessDomains()->where('item',$access_domain)->first()){
            return true;
        }

        return false;
    }
}
