<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessDomain extends Model
{
    use HasFactory;
    protected $table = 'access_domains';
    
    public function users(){
        return $this->belongsToMany('User','access_domain_users','access_domain_id','user_id');
    }

    public function jobs(){
        return $this->belongsToMany('Jobs','job_access_domains','access_domain_id','job_id');
    }
}
