<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
    public function users(){
        return $this->belongsToMany('User','role_users','role_id','user_id');
    }
    
    public function jobs(){
        return $this->belongsToMany('Jobs','job_roles','role_id','job_id');
    }
}
